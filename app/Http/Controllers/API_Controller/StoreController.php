<?php

namespace App\Http\Controllers\API_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

use App\Store;
use App\Store_Bank_Account;
use App\Store_Courier_Service;
use App\Store_Supporting_Document;
use App\Product;
use App\Product_Size;
use App\Product_Price;

class StoreController extends Controller
{
    private $jwt_key;
    public function __construct(){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }

    public function get_user_store(Request $request) {
        $have_store = false;
        $store = null;
        $jwt = $request->token;
        $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
        $user_id = $decoded->data->user_id;

        $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

        if ($store) {
            $have_store = true;
        }

        return response()->json(['have_store'=>$have_store,'store'=>$store],200);
    }

    public function check_store_name(Request $request) {
        $status = true;
        $message = "";
        $store_dbase = DB::table('store')->where('name',$request->store_name)->count();
        if ($store_dbase > 0) {
            $status = false;
            $message = "Store Name Already Exists";
        }
        else {
            $message = "Store Name Available";
        }
        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function register_store_name(Request $request) {
        $status = true;
        $message = "";
        $store_dbase = DB::table('store')->where('name',$request->store_name)->count();
        if ($store_dbase > 0) {
            $status = false;
            $message = "Store Name Already Exists";
        }
        else {
            try {
                $jwt = $request->token;
                $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
                $user_id = $decoded->data->user_id;

                $user_store_count = DB::table('view_user_store')->where('user_id',$user_id)->count();

                if ($user_store_count > 0) {
                    $status = false;
                    $message = "You already have store";
                }

                else {
                    $store = Store::create([
                        'user_id' => $user_id,
                        'name' => $request->get('store_name'),
                        'store_active_status' => "0"
                    ]);

                    $status = true;
                    $message = "Store Name registered successfully ";
                }
            }
            catch(Exception $error) {
                return response()->json(['error'=>'something went wrong, try again later'],500);
            }
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function register_store (Request $request) {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $user_store_count = DB::table('view_user_store')->where('user_id',$user_id)->where('store_name',$request->get('store_name'))->count();

            if ($user_store_count == 0) {
                $status = false;
                $message = "You don't have privilege";
            }

            else {
                DB::beginTransaction();
                try {
                    $store = Store::where('name', $request->store_name)->first();
                    $store->description = $request->description;
                    $store->established_year = $request->established_year;
                    $store->province = $request->province;
                    $store->city = $request->city;
                    $store->business_type = $request->business_type;
                    $store->contact_person_name = $request->contact_person_name;
                    $store->contact_person_job_title = $request->contact_person_job_title;
                    $store->contact_person_phone_number = $request->contact_person_phone_number;

                    $photo = $request->file('photo');
                    if ($photo) {
                        $photo_path = $photo->storeAs('Store/photo', $request->store_name."_photo.".$photo->getClientOriginalExtension() , 'public');
                        $store->photo = $photo_path;
                    }

                    $banner = $request->file('banner');
                    if ($banner) {
                        $banner_path = $banner->storeAs('Store/banner', $request->store_name."_banner.".$banner->getClientOriginalExtension() , 'public');
                        $store->banner = $banner_path;
                    }

                    $store->save();

                    $store_id = $store->store_id;

                    $store_supporting_document = new Store_Supporting_Document();
                    $store_supporting_document->store_id = $store_id;
                    $ktp = $request->file('ktp');
                    if ($ktp) {
                        $ktp_path = $ktp->storeAs('Store/documents/ktp', $request->store_name."_ktp.".$ktp->getClientOriginalExtension() , 'public');
                        $store_supporting_document->ktp = $ktp_path;
                    }

                    $siup = $request->file('siup');
                    if ($siup) {
                        $siup_path = $siup->storeAs('Store/documents/siup', $request->store_name."_siup.".$siup->getClientOriginalExtension() , 'public');
                        $store_supporting_document->siup = $siup_path;
                    }

                    $npwp = $request->file('npwp');
                    if ($npwp) {
                        $npwp_path = $npwp->storeAs('Store/documents/npwp', $request->store_name."_npwp.".$npwp->getClientOriginalExtension() , 'public');
                        $store_supporting_document->npwp = $npwp_path;
                    }

                    $skdp = $request->file('skdp');
                    if ($skdp) {
                        $skdp_path = $skdp->storeAs('Store/documents/skdp', $request->store_name."_skdp.".$skdp->getClientOriginalExtension() , 'public');
                        $store_supporting_document->skdp = $skdp_path;
                    }

                    $tdp = $request->file('tdp');
                    if ($tdp) {
                        $tdp_path = $tdp->storeAs('Store/documents/tdp', $request->store_name."_tdp.".$tdp->getClientOriginalExtension() , 'public');
                        $store_supporting_document->tdp = $tdp_path;
                    }

                    $store_supporting_document->save();

                    // $store_bank_account = new Store_Bank_Account();
                    // $store_bank_account->store_id = $store_id;
                    // $store_bank_account->bank_name = $request->bank_name;
                    // $store_bank_account->branch = $request->branch;
                    // $store_bank_account->bank_account_number = $request->bank_account_number;
                    // $store_bank_account->name_in_bank = $request->name_in_bank_account;

                    // $store_bank_account->save();

                    $courier = $request->courier;
                    foreach($courier as $c) {
                        $store_courier_service = new Store_Courier_Service();
                        $store_courier_service->store_id = $store_id;
                        $store_courier_service->courier_id= $c;

                        $store_courier_service->save();
                    }

                    DB::commit();
                    $status = true;
                    $message = "Store registered successfully ";
                }

                catch(Exception $error) {
                    DB::rollback();
                    $status = false;
                    $message = $error->getMessage();
                }
            }
        }
        catch(Exception $error) {
            return response()->json(['error'=>$error],500);
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function add_product (Request $request) {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            if ($store == null) {
                $status = false;
                $message = "You don't have privilege";
            }

            else {
                DB::beginTransaction();
                try {
                    $product = new Product();
                    $product->store_id = $store->store_id;
                    $product->name = $request->name;
                    $product->min_order = $request->min_order;
                    $product->weight = $request->weight;
                    $product->description = $request->description;
                    $product->style_id = $request->style_id;
                    $product->season_id = $request->season_id;
                    $product->neckline_id = $request->neckline_id;
                    $product->sleevelength_id = $request->sleevelength_id;
                    $product->waiseline_id = $request->waiseline_id;
                    $product->material_id = $request->material_id;
                    $product->fabrictype_id = $request->fabrictype_id;
                    $product->decoration_id = $request->decoration_id;
                    $product->patterntype_id = $request->patterntype_id;
                    $product->product_type = "0";
                    $product->product_active_status = "0";
                    $product->product_ownership = "0";

                    $product->save();

                    $product_id = $product->product_id;

                    $photo = $request->file('photo');
                    if ($photo) {
                        $photo_path = $photo->storeAs('Product/photo', $product_id."_photo.".$photo->getClientOriginalExtension() , 'public');
                        
                        $product = Product::where('product_id', $product_id)->first();
                        $product->photo = $photo_path;

                        $product->save();
                    }

                    $size = $request->size;

                    if ($size) {
                        foreach($size as $sz) {
                            $product_size = new Product_Size();
                            $product_size->product_id = $product_id;
                            $product_size->size_id = $sz;

                            $product_size->save();
                            // DB::table('product_size')->insert([
                            //     ['product_id' => $product_id, 'size_id' => $sz]
                            // ]);
                        }
                    }

                    $price = $request->price;
                    if ($price) {
                        foreach($price as $pr) {
                            $product_price = new Product_Price();
                            $product_price->product_id = $product_id;
                            $product_price->qty_min = $pr['qty_min'];
                            $product_price->qty_max = $pr['qty_max'];
                            $product_price->price = $pr['price'];

                            $product_price->save();
                        }
                    }   
                    DB::commit();
                    $status = true;
                    $message = "Product registered successfully ";
                }

                catch(Exception $error) {
                    DB::rollback();
                    $status = false;
                    $message = $error->getMessage();
                }
            }
        }
        catch(Exception $error) {
            return response()->json(['error'=>$error],500);
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function seller_get_order (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            if ($store) {
                $order = DB::table('view_store_order')
                        ->where('store_id', $store->store_id)
                        ->where('state', '2')
                        ->where('order_status', 'Waiting Seller Response')
                        ->get();

                foreach ($order as $o)
                {
                    $product = DB::table('view_transaction_summary_product')
                                        ->select(DB::raw('product_id, product_name, product_photo, price_unit, total_qty, price_total'))
                                        ->where('transaction_id',$o->transaction_id)
                                        ->where('store_id',$o->store_id)
                                        ->get();
                    foreach ($product as $p) {
                        $product_size = DB::table('view_transaction_detail_product')
                                ->select(DB::raw('product_id, product_size_id, size_name, product_qty '))
                                ->where('transaction_id',$o->transaction_id)
                                ->where('store_id',$o->store_id)
                                ->where('product_id',$p->product_id)
                                ->get();
                        $p->size_info = $product_size;
                    }
                    $o->product = $product;
                }
                return response()->json(['status'=>true,'result'=>$order],200);
            }
            else {
                return response()->json(['status'=>false,'message'=>"You don't have store"],200);
            }
        }
        catch (Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function approve_order_product (Request $request)
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
            $product = $request->product;

            foreach ($product as $p) {
                $p = (object)$p;
                if ($p->status == "1") {
                    DB::table('sales_transaction_product')
                    ->where('transaction_id', $transaction_id)
                    ->where('product_id', $p->product_id)
                    ->update(['accept_status' => "1"]);
                }
                else if ($p->status == "2") {
                    DB::table('sales_transaction_product')
                    ->where('transaction_id', $transaction_id)
                    ->where('product_id', $p->product_id)
                    ->update(['accept_status' => "2"]);
                }
            }

            DB::table('sales_transaction_state')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->update(
                [ 
                    'state' => '3'
                ]
            );

            DB::table('sales_transaction_order_status')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->update(
                [ 
                    'status' => '1'
                ]
            );

            //print_r($product);

            DB::commit();
            $status = true;
            $message = "Approved Successfully";
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function seller_get_shipping_confirmation (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            if ($store) {
                $order = DB::table('view_order_shipping')
                        ->where('store_id', $store->store_id)
                        ->where('state', '3')
                        ->where('shipping_status', '0')
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

                    // if (sizeof($product) == 0) {
                    //     $product_res = "No Product";
                    // }
                    // else {
                    //     $product_res = $product;
                    // }
                    $o->product = $product;
                    
                }

                return response()->json(['status'=>true,'result'=>$order],200);
            }
            else {
                return response()->json(['status'=>false,'message'=>"You don't have store"],200);
            }
        }
        catch (Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function input_receipt_number(Request $request)
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
            $receipt_number = $request->receipt_number;

            DB::table('sales_transaction_shipping')
            ->where('transaction_id', $transaction_id)
            ->where('store_id', $store_id)
            ->update(
                [ 
                    'shipping_status' => '1',
                    'receipt_number' => $receipt_number,
                ]
            );

            //print_r($product);

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

    public function finish_shipping(Request $request)
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
                    'shipping_status' => '1',
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
