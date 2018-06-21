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
use App\Cart;
use App\Sales_Transaction_Header;
use App\Sales_Transaction_Payment;
use App\Withdraw;

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

            $transaction = DB::table('view_order_status')
                        ->where('state', '2')
                        ->orWhere('state', '3')
                        ->where('user_id', $user_id)
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
                    $message = "Submitted Successfully";
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
}
