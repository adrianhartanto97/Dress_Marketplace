<?php

namespace App\Http\Controllers\API_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Exception;
use \stdClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use GuzzleHttp\Client;

use App\Store;
use App\Store_Courier_Service;
use App\Product;
use App\Product_Size;
use App\Product_Price;
use App\Product_Report;
use App\Cart;
use App\Sales_Transaction_Header;
use App\Sales_Transaction_Payment;
use App\Withdraw;
use App\Store_Rating;
use App\Product_Review_Rating;
use App\RFQ_Request;

class TransactionController extends Controller
{
    private $jwt_key;
    public function __construct(){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }

    public function add_to_bag (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $product_id = $request->product_id;
            $product_size_qty = $request->product_size_qty;
            foreach ($product_size_qty as $p) {
                $p = (object)$p;

                if ($p->qty > 0) {
                    //cek cart
                    $product_db = DB::table('cart')
                                ->where([
                                    'user_id' =>$user_id,
                                    'product_id' => $product_id,
                                    'product_size_id' => $p->size_id
                                ])
                                ->first();
                    
                    //jika sudah ada, update
                    if ($product_db != null) {
                        $product_db = DB::table('cart')
                                ->where([
                                    'user_id' =>$user_id,
                                    'product_id' => $product_id,
                                    'product_size_id' => $p->size_id
                                ])
                                ->update(['product_qty' => $p->qty + $product_db->product_qty]);
                    }

                    //jika belum ada, insert
                    else {
                        $cart = new Cart();
                        $cart->user_id = $user_id;
                        $cart->product_id = $product_id;
                        $cart->product_size_id = $p->size_id;
                        $cart->product_qty = $p->qty;

                        $cart->save();
                    }
                    //var_dump($p);
                }
            }

            DB::commit();
            $status = true;
            $message = "Product Added to Cart Successfully";
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function view_shopping_bag (Request $request) {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $bag = DB::table('view_cart_summary')
                    ->select(DB::raw('DISTINCT store_id, store_name, store_photo'))
                    ->where('user_id',$user_id)
                    ->get();
            foreach ($bag as $b) {
                $product = DB::table('view_cart_summary')
                            ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                            ->where('user_id',$user_id)
                            ->where('store_id',$b->store_id)
                            ->get();
                foreach ($product as $p) {
                    $product_size = DB::table('view_cart_detail')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('user_id',$user_id)
                            ->where('store_id',$b->store_id)
                            ->where('product_id',$p->product_id)
                            ->get();
                    $p->size_info = $product_size;
                }
                $b->product = $product;
            }

            $total_qty = DB::table('view_cart_summary')
                        ->select(DB::raw('coalesce(sum(total_qty),0) as "total_qty"'))
                        ->where('user_id',$user_id)
                        ->first()->total_qty;
            $total_price = DB::table('view_cart_summary')
                        ->select(DB::raw('coalesce(sum(price_total),0) as "total_price"'))
                        ->where('user_id',$user_id)
                        ->first()->total_price;
            $status = true;
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
        return response()->json(['status'=>$status,'bag'=>$bag,'total_qty'=>$total_qty, 'total_price'=>$total_price],200);
    }

    public function delete_product_from_bag (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $product_id = $request->product_id;
            
            $product = DB::table('view_cart_detail')
                    ->where([
                        'user_id' =>$user_id,
                        'product_id' => $product_id
                    ])->first();

            DB::table('cart')
                ->where([
                    'user_id' =>$user_id,
                    'product_id' => $product_id
                ])->delete();

            DB::commit();
            $status = true;
            $message = $product->product_name." Deleted from Bag";
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

     public function delete_all_product_from_bag (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;


            DB::table('cart')
                ->where([
                    'user_id' =>$user_id,
                ])->delete();

            DB::commit();
            $status = true;
            $message = " All product deleted from Bag";
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }



    public function get_checkout_info(Request $request) {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $bag = DB::table('view_cart_summary')
                    ->select(DB::raw('DISTINCT store_id, store_name, store_photo'))
                    ->where('user_id',$user_id)
                    ->get();
            foreach ($bag as $b) {
                $total_weight = 0;
                $total_qty = 0;
                $total_price = 0;
                $product = DB::table('view_cart_summary')
                            ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total, total_weight'))
                            ->where('user_id',$user_id)
                            ->where('store_id',$b->store_id)
                            ->get();
                foreach ($product as $p) {
                    $product_size = DB::table('view_cart_detail')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('user_id',$user_id)
                            ->where('store_id',$b->store_id)
                            ->where('product_id',$p->product_id)
                            ->get();
                    $p->size_info = $product_size;

                    $total_weight += (int)$p->total_weight;
                    $total_qty += (int)$p->total_qty;
                    $total_price += (int)$p->price_total;
                }
                $b->product = $product;
                $b->total_qty = $total_qty;
                $b->total_price = $total_price;

                $store =  DB::table('store')
                            ->where('store_id',$b->store_id)
                            ->first();

                $client = new Client();

                $master_courier = $users = DB::table('store_courier_service as a')
                                ->join('master_courier as b', 'a.courier_id', '=', 'b.courier_id')
                                ->select('b.courier_id', 'b.courier_name', 'b.alias_name')
                                ->where('a.store_id',$b->store_id)
                                ->get();
                
                $arr = [];
                foreach ($master_courier as $c) {
                    $result = new stdClass();
                    $api = $client->post('https://api.rajaongkir.com/starter/cost', [
                        'headers' => [
                            'key' => '727457f12c70c429f153a24a259d4d64'
                        ],
                        'verify' => false,
                        'form_params' => [
                            'origin' => $store->city,
                            'destination' => $request->destination_city,
                            'weight' => $total_weight,
                            'courier' => $c->alias_name
                        ]
                    ]);
                    $result->courier_id = $c->courier_id;
                    $result->courier_name = $c->courier_name;
                    $result->query = json_decode($api->getBody())->rajaongkir->query;
                    $result->cost = json_decode($api->getBody())->rajaongkir->results[0]->costs;

                    array_push($arr,$result);
                }

                $b->courier_service = $arr;
            }
            $total_qty = DB::table('view_cart_summary')
                        ->select(DB::raw('coalesce(sum(total_qty),0) as "total_qty"'))
                        ->where('user_id',$user_id)
                        ->first()->total_qty;
            $total_price = DB::table('view_cart_summary')
                        ->select(DB::raw('coalesce(sum(price_total),0) as "total_price"'))
                        ->where('user_id',$user_id)
                        ->first()->total_price;
            $user = DB::table('user')
                    ->select('balance')
                    ->where('user_id',$user_id)
                    ->first();
            $available_points = $user->balance;
            
            $status = true;
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
        return response()->json(['status'=>$status,'result'=>$bag, 'total_qty'=>$total_qty, 'total_price'=>$total_price , 'available_points' => $available_points],200);
    }

    public function checkout(Request $request)
    {
        $status = true;
        $message="";
        $data = null;
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $transaction = new Sales_Transaction_Header();
            $transaction->user_id = $user_id;
            $transaction->receiver_name = $request->receiver_name;
            $transaction->address = $request->address;
            $transaction->province = $request->province;
            $transaction->city = $request->city;
            $transaction->phone_number = $request->phone_number;
            $transaction->postal_code = $request->postal_code;
            $transaction->use_point = $request->use_point;

            $transaction->save();
            $transaction_id = $transaction->transaction_id;

            $bag = DB::table('cart')
                    ->where('user_id',$user_id)
                    ->get();
            
            foreach($bag as $b)
            {
                DB::table('sales_transaction_product')->insert([
                        'transaction_id' => $transaction_id, 
                        'product_id' => $b->product_id,
                        'product_size_id' => $b->product_size_id,
                        'product_qty' => $b->product_qty,
                        'accept_status' => '0'
                    ]
                );
            }

            $courier = $request->courier;

            foreach ($courier as $c)
            {
                $c = (object)$c;
                DB::table('sales_transaction_shipping')->insert([
                    'transaction_id' => $transaction_id, 
                    'store_id' => $c->store_id,
                    'courier_id' => $c->courier_id,
                    'courier_service' => $c->courier_service,
                    'fee' => $c->fee,
                    'note' => $c->note,
                    'shipping_status' => '0',
                    'receipt_status' => '0'
                ]
                );
            }

            foreach ($courier as $c)
            {
                $c = (object)$c;
                DB::table('sales_transaction_state')->insert([
                    'transaction_id' => $transaction_id, 
                    'store_id' => $c->store_id,
                    'order_number' => "ORD-".$transaction_id."-".$c->store_id,
                    'state' => '1'
                ]
                );

                DB::table('sales_transaction_order_status')->insert([
                    'transaction_id' => $transaction_id, 
                    'store_id' => $c->store_id,
                    'status' => '0'
                ]
                );
            }

            DB::table('user')
                ->where('user_id', $user_id)
                ->update(['balance' => DB::raw("balance - ".$request->use_point)]);


            DB::table('cart')
            ->where([
                'user_id' =>$user_id
            ])->delete();

            DB::commit();
            $status = true;
            $message = "Checkout Successfully";

            $data = new stdClass();

            $data->transaction_id = $transaction_id;
            $data->total_price = DB::table('view_transaction_summary')
                            ->where('transaction_id',$transaction_id)
                            ->first()->total_price;
            $data->bank = DB::table('company_bank_account')
                            ->get();
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message, 'data' =>$data],200);
    }

    public function get_purchase_payment(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            // $transaction = DB::table('view_sales_transaction_payment')
            //             ->where('payment_status', 'Waiting for Payment')
            //             ->orWhere('payment_status', 'Payment Confirmation Sent')
            //             ->where('user_id', $user_id)
            //             ->get();
            // $q->where(function ($query) {
            //     $query->where('gender', 'Male')
            //         ->where('age', '>=', 18);
            // })->orWhere(function($query) {
            //     $query->where('gender', 'Female')
            //         ->where('age', '>=', 65);	
            // })
            $transaction = DB::table('view_sales_transaction_payment')
                            ->where('user_id', $user_id)
                            ->where(function ($query) {
                                $query->where('payment_status', 'Waiting for Payment')
                                    ->orWhere('payment_status', 'Payment Confirmation Sent');
                            })
                            ->get();

            foreach ($transaction as $t) {
                $order_store = DB::table('view_sales_transaction_store')
                                ->where('transaction_id', $t->transaction_id)
                                ->where('user_id', $user_id)
                                ->get();
                $t->order_store = $order_store; 
                foreach ($order_store as $store)
                {
                    
                    $product = DB::table('view_transaction_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$store->transaction_id)
                                ->where('store_id',$store->store_id)
                                ->get();
                    foreach ($product as $p) {
                        $product_size = DB::table('view_transaction_detail_product')
                                ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                                ->where('transaction_id',$store->transaction_id)
                                ->where('store_id',$store->store_id)
                                ->where('product_id',$p->product_id)
                                ->get();
                        $p->size_info = $product_size;
                    }
                    $store->product = $product;
                    
                }
            }

            $bank = DB::table('company_bank_account')
                    ->get();
            $status = true;
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }

        return response()->json(['status'=>$status,'result'=>$transaction,'bank'=>$bank],200);
    }

    public function confirm_payment(Request $request)
    {
        try {
            $transaction_id = $request->transaction_id;
            $company_bank_id = $request->company_bank_id;
            $amount = $request->amount;
            $sender_bank = $request->sender_bank;
            $sender_account_number = $request->sender_account_number;
            $sender_name = $request->sender_name;
            $note = $request->note;
            $date = $request->date;

            $payment_status = DB::table('view_sales_transaction_payment')
                            ->where('transaction_id', $transaction_id)
                            ->first()->payment_status;
            
            $payment = null;
            
            if ($payment_status == 'Waiting for Payment'){
                $payment = new Sales_Transaction_Payment();
                $payment->transaction_id = $transaction_id;
            }
            else if ($payment_status == 'Payment Confirmation Sent') {
                $payment = Sales_Transaction_Payment::find($transaction_id);
            }

            $payment->company_bank_id = $company_bank_id;
            $payment->amount = $amount;
            $payment->sender_bank = $sender_bank;
            $payment->sender_account_number = $sender_account_number;
            $payment->sender_name = $sender_name;
            $payment->note = $note;
            $payment->status = '0';
            $payment->date = $date;

            $payment->save();
            DB::commit();
            $status = true;
            $message = "Invoice ".$transaction_id." Payment Confirmation Submitted Successfully";
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
        catch (Exception $error) {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function get_order_status(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            // $transaction = DB::table('view_order_status')
            //             ->where('state', '2')
            //             ->orWhere('state', '3')
            //             ->where('user_id', $user_id)
            //             ->get();
            $transaction = DB::table('view_order_status')
                            ->where('user_id', $user_id)
                            ->where(function ($query) {
                                $query->where('state', '2')
                                    ->orWhere('state', '3');
                            })
                            ->get();
                            
            foreach ($transaction as $t) {   
                $product = DB::table('view_transaction_summary_product')
                            ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->get();
                foreach ($product as $p) {
                    $product_size = DB::table('view_transaction_detail_product')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('product_id',$p->product_id)
                            ->get();
                    $p->size_info = $product_size;
                }
                $t->product_ordered = $product;

                if ($t->state== '3' && $t->order_status == 'Order Approved') {
                    $accept = DB::table('view_order_approve_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$t->transaction_id)
                                ->where('store_id',$t->store_id)
                                ->where('accept_status','1')
                                ->get();
                    foreach($accept as $a) {
                        $product_size = DB::table('view_order_approve_detail_product')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('accept_status','1')
                            ->where('product_id',$a->product_id)
                            ->get();
                        $a->size_info = $product_size;
                    }
                    $t->product_accepted = $accept;

                    $reject = DB::table('view_order_approve_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$t->transaction_id)
                                ->where('store_id',$t->store_id)
                                ->where('accept_status','2')
                                ->get();
                    foreach($reject as $r) {
                        $product_size = DB::table('view_order_approve_detail_product')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('accept_status','2')
                            ->where('product_id',$r->product_id)
                            ->get();
                        $r->size_info = $product_size;
                    }
                    $t->product_rejected = $reject;
                }
            }
            $status = true;
            return response()->json(['status'=>$status,'result'=>$transaction],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function get_receipt_confirmation (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            
            $order = DB::table('view_order_shipping')
                    ->where('user_id', $user_id)
                    ->where('state', '3')
                    ->where('shipping_status', '1')
                    ->get();

            foreach ($order as $o)
            {
                $product = DB::table('view_order_approve_summary_product')
                                    ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                    ->where('transaction_id',$o->transaction_id)
                                    ->where('store_id',$o->store_id)
                                    ->where('accept_status','1')
                                    ->get();
                foreach ($product as $p) {
                    $product_size = DB::table('view_order_approve_detail_product')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('transaction_id',$o->transaction_id)
                            ->where('store_id',$o->store_id)
                            ->where('accept_status','1')
                            ->where('product_id',$p->product_id)
                            ->get();
                    $p->size_info = $product_size;
                }

            
                $o->product = $product;
                    
            }

                return response()->json(['status'=>true,'result'=>$order],200);
            
        }
        catch (Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function confirm_receipt(Request $request)
    {
        $status = true;
        $message="";
        $data = null;
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $transaction_id = $request->transaction_id;
            $store_id = $request->store_id;

            DB::table('sales_transaction_shipping')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->update(
                [ 
                    'receipt_status' => '1',
                ]
            );

            DB::table('sales_transaction_state')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->update(
                [ 
                    'state' => '4'
                ]
            );

            //uang pembeli
            $buyer = DB::table('view_order_money_movement')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->where('status', '2')
            ->first();

            DB::table('user')
            ->where('user_id', $buyer->buyer_id)
            ->update(
                [ 
                    'balance' => DB::raw("balance + ".$buyer->total_receive)
                ]
            );

            //uang penjual
            $seller = DB::table('view_order_money_movement')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->where('status', '1')
            ->first();

            DB::table('user')
            ->where('user_id', $seller->seller_id)
            ->update(
                [ 
                    'balance' => DB::raw("balance + ".$seller->total_receive)
                ]
            );

            //print_r($product);

            DB::commit();
            $status = true;
            $message = "Confirm Successfully";
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function withdraw (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $amount = $request->amount;
            $bank_name = $request->bank_name;
            $branch = $request->branch;
            $account_number = $request->account_number;
            $name_in_account = $request->name_in_account;
            $password = $request->password;

            $balance = DB::table('user')
                        ->where('user_id', $user_id)
                        ->first()->balance;

            if ($amount > $balance) {
                $status = false;
                $message = "Insufficient balance";
            }
           
            else {
                $password_dbase = DB::table('user')->where('user_id',$user_id)->first()->password;

                if(!Hash::check($password, $password_dbase))
                {
                    $status = false;
                    $message = "Wrong Password";
                }
                else {
                    $withdraw = new Withdraw();
                    $withdraw->user_id = $user_id;
                    $withdraw->amount = $amount;
                    $withdraw->bank_name = $bank_name;
                    $withdraw->branch = $branch;
                    $withdraw->account_number = $account_number;
                    $withdraw->name_in_account = $name_in_account;

                    $withdraw->save();

                    DB::table('user')
                    ->where('user_id', $user_id)
                    ->update(
                        [ 
                            'balance' => DB::raw("balance - ".$amount)
                        ]
                    );

                    DB::commit();
                    $status = true;
                    $message = "Withdraw Successfully";
                }
            }  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function get_review_rating (Request $request) 
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $order = DB::table('view_order_store_approval')
                    ->where('user_id', $user_id)
                    ->where('state', '4')
                    ->get();

            foreach ($order as $o)
            {
                $product = DB::table('view_order_approve_summary_product')
                                    ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                    ->where('transaction_id',$o->transaction_id)
                                    ->where('store_id',$o->store_id)
                                    ->where('accept_status','1')
                                    ->get();
                
                $o->product = $product;     
            }

                return response()->json(['status'=>true,'result'=>$order],200);
            
        }
        catch (Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function submit_review_rating (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $transaction_id = $request->transaction_id;
            $store_id = $request->store_id;
            $store_rating = $request->store_rating;
            $product_rating = $request->product_rating;

            $store = new Store_Rating();
            $store->transaction_id = $transaction_id;
            $store->store_id = $store_id;
            $store->rating = $store_rating;
            $store->status = "1";
            $store->save();

            if (sizeof ($product_rating) > 0) {
                foreach ($product_rating as $p)
                {
                    $p = (object)$p;
                    $product = new Product_Review_Rating();
                    $product->transaction_id = $transaction_id;
                    $product->product_id = $p->product_id;
                    $product->rating = $p->rating;
                    $product->review = $p->review;
                    $product->status = "1";

                    $product->save();
                }
            }
            DB::table('sales_transaction_state')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->update(
                [ 
                    'state' => '5'
                ]
            );
            //print_r($product_rating);
            DB::commit();
            $status = true;
            $message = "Submitted Successfully";  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function reject_payment_history (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $invoice = DB::table('view_sales_transaction_payment AS a')
                        ->join('company_bank_account AS b', 'a.company_bank_id', '=', 'b.bank_id')
                        ->select('a.*', 'b.bank_name as company_bank_name', 'b.branch as company_bank_branch', 'b.account_number as company_bank_account_number', 'name_in_account as company_bank_name_account', 'logo as company_bank_logo')
                        ->where('user_id', $user_id)
                        ->where('payment_status', 'Reject')
                        ->get();

            foreach ($invoice as $t) {
                $order_store = DB::table('view_sales_transaction_store')
                                ->where('transaction_id', $t->transaction_id)
                                ->where('user_id', $user_id)
                                ->get();
                $t->order_store = $order_store; 
                foreach ($order_store as $store)
                {
                    
                    $product = DB::table('view_transaction_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$store->transaction_id)
                                ->where('store_id',$store->store_id)
                                ->get();
                    foreach ($product as $p) {
                        $product_size = DB::table('view_transaction_detail_product')
                                ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                                ->where('transaction_id',$store->transaction_id)
                                ->where('store_id',$store->store_id)
                                ->where('product_id',$p->product_id)
                                ->get();
                        $p->size_info = $product_size;
                    }
                    $store->product = $product;
                    
                }
            }

            $status = true;
            return response()->json(['status'=>$status,'result'=>$invoice],200);
            
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function transaction_history (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $invoice = DB::table('view_order_status')
                        ->distinct('transaction_id', 'invoice_date')
                        ->where('user_id', $user_id)
                        ->where('state', '5')
                        ->get();
            
            foreach($invoice as $i) {
                $transaction = DB::table('view_order_status')
                    ->where('user_id', $user_id)
                    ->where('state', '5')
                    ->where('transaction_id', $i->transaction_id)
                    ->get();
                $i->transaction = $transaction;

                foreach ($transaction as $t) {   
                    $product = DB::table('view_transaction_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$t->transaction_id)
                                ->where('store_id',$t->store_id)
                                ->get();
                    foreach ($product as $p) {
                        $product_size = DB::table('view_transaction_detail_product')
                                ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                                ->where('transaction_id',$t->transaction_id)
                                ->where('store_id',$t->store_id)
                                ->where('product_id',$p->product_id)
                                ->get();
                        $p->size_info = $product_size;
                    }
                    $t->product_ordered = $product;
    
                    
                    $accept = DB::table('view_order_approve_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$t->transaction_id)
                                ->where('store_id',$t->store_id)
                                ->where('accept_status','1')
                                ->get();
                    foreach($accept as $a) {
                        $product_size = DB::table('view_order_approve_detail_product')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('accept_status','1')
                            ->where('product_id',$a->product_id)
                            ->get();
                        $a->size_info = $product_size;
                    }
                    $t->product_accepted = $accept;
    
                    $reject = DB::table('view_order_approve_summary_product')
                                ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                ->where('transaction_id',$t->transaction_id)
                                ->where('store_id',$t->store_id)
                                ->where('accept_status','2')
                                ->get();
                    foreach($reject as $r) {
                        $product_size = DB::table('view_order_approve_detail_product')
                            ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('accept_status','2')
                            ->where('product_id',$r->product_id)
                            ->get();
                        $r->size_info = $product_size;
                    }
                    $t->product_rejected = $reject;
                    
                }
            }
                            
            
            $status = true;
            return response()->json(['status'=>$status,'result'=>$invoice],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function add_rfq_request (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $rfq = new RFQ_Request();
            $rfq->user_id = $user_id;
            $rfq->item_name = $request->item_name;
            $rfq->description = $request->description;
            $rfq->qty = $request->qty;
            $rfq->request_expired = $request->request_expired;
            $rfq->budget_unit_min = $request->budget_unit_min;
            $rfq->budget_unit_max = $request->budget_unit_max;
            $rfq->status = "0";
            $rfq->save();

            $rfq_request_id = $rfq->rfq_request_id;

            $photo = $request->file('photo');
            if ($photo) {
                $photo_path = $photo->storeAs('rfq/request', $rfq_request_id."_photo.".$photo->getClientOriginalExtension() , 'public');
                
                DB::table('rfq_request_files')->insert([
                    'rfq_request_id' => $rfq_request_id, 
                    'file_path' => $photo_path
                ]
                );
            }

            DB::commit();
            $status = true;
            $message = "Submitted Successfully";  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function view_active_rfq_request (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $rfq = DB::table('rfq_request')
                    ->select('*')
                    ->where('user_id',$user_id)
                    ->where('status',"0")
                    ->where('request_expired','>',DB::raw('now()'))
                    ->get();

            foreach ($rfq as $r) {
                $photo = DB::table('rfq_request_files')
                        ->select('file_path')
                        ->where('rfq_request_id',$r->rfq_request_id)
                        ->first();
                $r->photo = $photo;

                $offer = DB::table('view_rfq_offer')
                            ->select('*')
                            ->where('rfq_request_id',$r->rfq_request_id)
                            ->get();
                foreach ($offer as $o) {
                    $offer_photo = DB::table('rfq_offer_files')
                                    ->select('file_path')
                                    ->where('rfq_offer_id',$o->rfq_offer_id)
                                    ->first();
                    $o->photo = $offer_photo;
                }
                $r->offer = $offer;
            }
            
            $status = true;
            return response()->json(['status'=>$status,'result'=>$rfq],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function accept_rfq_offer (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $rfq_offer_id = $request->rfq_offer_id;

            $offer = DB::table('view_rfq_offer')
                    ->select('*')
                    ->where('rfq_offer_id',$rfq_offer_id )
                    ->first();
            $offer_photo = DB::table('rfq_offer_files')
                            ->select('*')
                            ->where('rfq_offer_id',$rfq_offer_id )
                            ->first()->file_path;
            
            $product = new Product();
            $product->store_id = $offer->store_id;
            $product->name = "RFQ Product";
            $product->min_order = $offer->qty;
            $product->weight = $offer->weight_unit;
            $product->description = "RFQ Offer ID ".$offer->rfq_offer_id;
            $product->photo = $offer_photo;
            $product->style_id = 0;
            $product->season_id = 0;
            $product->neckline_id = 0;
            $product->sleevelength_id = 0;
            $product->waiseline_id = 0;
            $product->material_id = 0;
            $product->fabrictype_id = 0;
            $product->decoration_id = 0;
            $product->patterntype_id = 0;
            $product->product_type = "1";
            $product->product_active_status = "1";
            $product->product_ownership = "0";
            $product->save();

            $product_id = $product->product_id;

            $product_size = new Product_Size();
            $product_size->product_id = $product_id;
            $product_size->size_id = 5;
            $product_size->save();

            $product_price = new Product_Price();
            $product_price->product_id = $product_id;
            $product_price->qty_min = $offer->qty;
            $product_price->qty_max = "max";
            $product_price->price = $offer->price_unit;

            $product_price->save();

            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->product_id = $product_id;
            $cart->product_size_id = 5;
            $cart->product_qty = $offer->qty;

            $cart->save();

            $rfq_request  = RFQ_Request::find($offer->rfq_request_id);
            $rfq_request->status = "1";
            $rfq_request->accept_rfq_offer_id = $rfq_offer_id;
            $rfq_request->save();

            DB::commit();
            $status = true;
            $message = "Submitted Successfully";  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function close_rfq_request (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $rfq_request_id = $request->rfq_request_id;

            $rfq_request  = RFQ_Request::find($rfq_request_id);
            $rfq_request->status = "2";
            $rfq_request->save();

            DB::commit();
            $status = true;
            $message = "Submitted Successfully";  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function rfq_request_history (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $rfq = DB::table('view_rfq_request_history')
                    ->select('*')
                    ->where('user_id',$user_id)
                    ->get();

            foreach ($rfq as $r) {
                $photo = DB::table('rfq_request_files')
                        ->select('file_path')
                        ->where('rfq_request_id',$r->rfq_request_id)
                        ->first();
                $r->photo = $photo;

                
                $offer = DB::table('view_rfq_offer')
                            ->select('*')
                            ->where('rfq_request_id',$r->rfq_request_id)
                            ->get();
                foreach ($offer as $o) {
                    $offer_photo = DB::table('rfq_offer_files')
                                    ->select('file_path')
                                    ->where('rfq_offer_id',$o->rfq_offer_id)
                                    ->first();
                    $o->photo = $offer_photo;
                }
                $r->offer = $offer;
                

                if ($r->status == '1') {
                    $acc = DB::table('view_rfq_offer')
                            ->select('*')
                            ->where('rfq_offer_id',$r->accept_rfq_offer_id)
                            ->first();
                    $acc_photo = DB::table('rfq_offer_files')
                                ->select('file_path')
                                ->where('rfq_offer_id',$r->accept_rfq_offer_id)
                                ->first();
                    $acc->photo = $acc_photo;
                    $r->accepted_offer = $acc;
                }
            }
            
            $status = true;
            return response()->json(['status'=>$status,'result'=>$rfq],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function financial_history(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $year = $request->year;
            $month = $request->month; 

            $beginning_balance_table = DB::table('view_financial_history')
                                        ->where('user_id',$user_id)
                                        ->where('transaction_date', '<', $year.'-'.$month.-'01')
                                        ->orderBy('transaction_date', 'ASC')
                                        ->orderBy('priority', 'ASC')
                                        ->get();
            $r = 0;

            if (sizeof($beginning_balance_table) > 0) {
                foreach($beginning_balance_table as $b) {
                    if($b->transaction_status == "DB") {
                        $r += (int)$b->amount;
                    }
                    else {
                        $r -= (int)$b->amount;
                    }
                }
            }

            $result = [];
            $beginning_balance = new stdClass();
            $beginning_balance->date = $year.'-'.$month.'-'.'01 00:00:00';
            $beginning_balance->transaction = "BEGINNING BALANCE";
            $beginning_balance->debit = $r;
            $beginning_balance->credit = 0;
            $beginning_balance->balance = $r;
            $beginning_balance->note = '';
            array_push($result, $beginning_balance);
            $next_month = (int)$month + 1;

            $transaction = DB::table('view_financial_history')
                            ->where('user_id',$user_id)
                            ->where('transaction_date', '>=', $year.'-'.$month.-'01')
                            ->where('transaction_date', '<', $year.'-'.$next_month.-'01')
                            ->orderBy('transaction_date', 'ASC')
                            ->orderBy('priority', 'ASC')
                            ->get();
            
            foreach($transaction as $t) {
                $tr = new stdClass();
                $tr->date = $t->transaction_date;
                $tr->transaction = $t->transaction_code." (".$t->transaction_number.")";
                if ($t->transaction_status=="DB") {
                    $tr->debit = $t->amount;
                    $tr->credit = 0;
                    $tr->balance = ($r += (int)$t->amount);
                }
                else {
                    $tr->debit = 0;
                    $tr->credit = $t->amount;
                    $tr->balance = ($r -= (int)$t->amount);
                }
                $tr->note = $t->note;
                array_push($result, $tr);
            }
            
            $status = true;
            return response()->json(['status'=>$status,'result'=>$result],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function report_product(Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $product_id = $request->product_id;
            $issue = $request->issue;
            $comment = $request->comment;

            $report = new Product_Report();
            $report->product_id = $product_id;
            $report->user_id = $user_id;
            $report->issue = $issue;
            $report->comment = $comment;
            $report->save();

            DB::commit();
            $status = true;
            $message = "Submitted Successfully";  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    function get_notification(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $result = DB::table('notification')
                        ->where('user_id', $user_id)
                        ->orderBy('date','desc')
                        ->get();

            $count_unread = DB::table('notification')
                            ->where('user_id', $user_id)
                            ->where('status_read',0)
                            ->count();
            
            $status = true;
            return response()->json(['status'=>$status,'result'=>$result, 'count_unread' => $count_unread],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function read_notification(Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $notification_id = $request->notification_id;

            $db = DB::table('notification')
                    ->where([
                        'id' =>$notification_id,
                        'user_id' => $user_id
                    ])
                    ->update(['status_read' => 1]);

            DB::commit();
            $status = true;
            $message = "Submitted Successfully";  
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }
}
