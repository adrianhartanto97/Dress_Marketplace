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
use App\Partnership_Request;
use App\Partnership_Request_Price;
use App\RFQ_Offer;

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

    public function get_request_partnership (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $result = [];
            $transaction = DB::table('view_order_status')
                            ->where('user_id', $user_id)
                            ->where('state', '5')
                            ->get();
                            
            foreach ($transaction as $t) {
                $accept = DB::table('view_order_approve_summary_product')
                            ->select(DB::raw('product_id, product_name, product_photo'))
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('accept_status','1')
                            ->get();
                
                if (sizeof($accept) > 0) {
                    $t->product = [];
                    foreach($accept as $a) {
                        $product_partnership = DB::table('view_request_partnership')
                            ->select('*')
                            ->where('transaction_id',$t->transaction_id)
                            ->where('store_id',$t->store_id)
                            ->where('accept_status','1')
                            ->where('product_id',$a->product_id)
                            ->where('store_id_partner', $store->store_id)
                            ->first();
                        
                        $price = DB::table('product_price')
                            ->select('*')
                            ->where("product_id" , $a->product_id)
                            ->get();
                
                        $a->price = $price;
                        

                        $has_partnership = false;
                        if ($product_partnership && $product_partnership->status == '0')
                        {
                            $a->has_partnership = true;
                            array_push($t->product,$a);
                        }
                        else if (!$product_partnership)
                        {
                            $a->has_partnership = false;
                            array_push($t->product,$a);
                        }
                        
                    }
                    
                    if (sizeof($t->product) > 0) {
                        array_push($result, $t);
                    }
                }
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

    public function submit_request_partnership (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $product_id = $request->product_id;
            $min_order = $request->min_order;
            $price = $request->price;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $upline = DB::table('product')->where('product_id',$product_id)->first();
            $upline_size = DB::table('product_size')->where('product_id',$product_id)->get();

            $product = new Product();
            $product->store_id = $store->store_id;
            $product->name = $upline->name." (Partnership)";
            $product->min_order = $min_order;
            $product->weight = $upline->weight;
            $product->description = $upline->description;
            $product->photo = $upline->photo;
            $product->style_id = $upline->style_id;
            $product->season_id = $upline->season_id;
            $product->neckline_id = $upline->neckline_id;
            $product->sleevelength_id = $upline->sleevelength_id;
            $product->waiseline_id = $upline->waiseline_id;
            $product->material_id = $upline->material_id;
            $product->fabrictype_id = $upline->fabrictype_id;
            $product->decoration_id = $upline->decoration_id;
            $product->patterntype_id = $upline->patterntype_id;
            $product->product_type = "0";
            $product->product_active_status = "0";
            $product->product_ownership = "1";
            $product->save();

            $product_id_partner = $product->product_id;

            foreach($upline_size as $sz) {
                $product_size = new Product_Size();
                $product_size->product_id = $product_id_partner;
                $product_size->size_id = $sz->size_id;

                $product_size->save();
            }

            $partnership = new Partnership_Request();
            $partnership->product_id = $product_id;
            $partnership->product_id_partner = $product_id_partner;
            $partnership->min_order = $min_order;
            $partnership->status = 0;

            $partnership->save();

            if ($price) {
                foreach($price as $pr) {
                    $partnership_price = new Partnership_Request_Price();
                    $partnership_price->product_id_partner = $product_id_partner;
                    $partnership_price->qty_min = $pr['qty_min'];
                    $partnership_price->qty_max = $pr['qty_max'];
                    $partnership_price->price = $pr['price'];

                    $partnership_price->save();
                }
            } 
            
            DB::commit();
            $status = true;
            $message = "Request Partnership Submitted Successfully";
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function upline_get_request_partnership (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $result = [];
            $transaction = DB::table('view_partnership_approval')
                            ->select(DB::raw('DISTINCT store_id_partner, store_name_partner'))
                            ->where('store_id', $store->store_id)
                            ->where('status', '0')
                            ->get();
            
            foreach ($transaction as $t) {
                $product = DB::table('view_partnership_approval')
                            ->select('*')
                            ->where('store_id', $store->store_id)
                            ->where('status', '0')
                            ->where('store_id_partner',$t->store_id_partner)
                            ->get();
                foreach ($product as $p)
                {
                    $price = DB::table('product_price')
                            ->select('*')
                            ->where('product_id', $p->product_id)
                            ->get();
                    $request_price = DB::table('partnership_request_price')
                                    ->select('*')
                                    ->where('product_id_partner', $p->product_id_partner)
                                    ->get();
                    
                    $p->price = $price;
                    $p->request_price = $request_price;
                }
                
                $t->product = $product;
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

    public function accept_partnership (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $partnership_id = $request->partnership_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $product_id_partner = DB::table('partnership_request')
                                    ->where('partnership_id', $partnership_id)->first()->product_id_partner;

            DB::table('partnership_request')
                    ->where('partnership_id', $partnership_id)
                    ->update(['status' => "1"]);

            DB::table('product')
                ->where('product_id', $product_id_partner)
                ->update(['product_active_status' => "1"]);

            $price = DB::table('partnership_request_price')
                    ->where('product_id_partner', $product_id_partner)
                    ->get();
            
            foreach($price as $p)
            {
                DB::table('product_price')->insert([
                    [
                        'product_id' => $product_id_partner, 
                        'qty_min' => $p->qty_min,
                        'qty_max' => $p->qty_max,
                        'price' => $p->price
                    ]
                ]);
            }

            DB::commit();
            $status = true;
            $message = "Partnership Accepted";
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function reject_partnership (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $partnership_id = $request->partnership_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $product_id_partner = DB::table('partnership_request')
                                    ->where('partnership_id', $partnership_id)->first()->product_id_partner;

            DB::table('partnership_request')
                    ->where('partnership_id', $partnership_id)
                    ->update(['status' => "2"]);

            DB::table('product')
                    ->where('product_id', $product_id_partner)
                    ->update(['product_active_status' => "2"]);
            
            DB::commit();
            $status = true;
            $message = "Partnership Rejected";
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
        catch(Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function upline_partner_list(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $result = [];
            $transaction = DB::table('view_partnership_approval')
                            ->select(DB::raw('DISTINCT store_id, store_name'))
                            ->where('store_id_partner', $store->store_id)
                            ->where('status', '<>', '0')
                            ->get();
            
            foreach ($transaction as $t) {
                $product = DB::table('view_partnership_approval')
                            ->select('*')
                            ->where('store_id_partner', $store->store_id)
                            ->where('status', '<>', '0')
                            ->where('store_id',$t->store_id)
                            ->get();
                foreach ($product as $p)
                {
                    $price = DB::table('product_price')
                            ->select('*')
                            ->where('product_id', $p->product_id)
                            ->get();
                    $request_price = DB::table('partnership_request_price')
                                    ->select('*')
                                    ->where('product_id_partner', $p->product_id_partner)
                                    ->get();
                    
                    $p->price = $price;
                    $p->request_price = $request_price;

                    if ($p->status == "1") $p->status="Accepted";
                    else if ($p->status == "2") $p->status="Rejected";
                }
                
                $t->product = $product;
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

    public function downline_partner_list(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();

            $result = [];
            $transaction = DB::table('view_partnership_approval')
                            ->select(DB::raw('DISTINCT store_id_partner, store_name_partner'))
                            ->where('store_id', $store->store_id)
                            ->where('status', '<>', '0')
                            ->get();
            
            foreach ($transaction as $t) {
                $product = DB::table('view_partnership_approval')
                            ->select('*')
                            ->where('store_id', $store->store_id)
                            ->where('status', '<>', '0')
                            ->where('store_id_partner',$t->store_id_partner)
                            ->get();
                foreach ($product as $p)
                {
                    $price = DB::table('product_price')
                            ->select('*')
                            ->where('product_id', $p->product_id)
                            ->get();
                    $request_price = DB::table('partnership_request_price')
                                    ->select('*')
                                    ->where('product_id_partner', $p->product_id_partner)
                                    ->get();
                    
                    $p->price = $price;
                    $p->request_price = $request_price;

                    if ($p->status == "1") $p->status="Accepted";
                    else if ($p->status == "2") $p->status="Rejected";
                }
                
                $t->product = $product;
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

    public function get_store_detail(Request $request)
    {
        try {
            $store_id = $request->store_id;
            $store = DB::table('view_store_active')
                    ->select('*')
                    ->where('store_id',$store_id)
                    ->first();

            $courier_service = DB::table('store_courier_service as a')
                                ->join('master_courier as b', 'a.courier_id', '=', 'b.courier_id')
                                ->select(DB::raw('a.courier_id,b.courier_name,b.alias_name,b.logo'))
                                ->where('a.store_id',$store_id)
                                ->get();

            $store->courier_service =$courier_service;
            $product = DB::table('view_product')
                        ->select(DB::raw('product_id,product_name,photo,store_name,average_rating'))
                        ->where('store_id',$store_id)
                        ->where('product_type','0')
                        ->where('product_active_status','1')
                        ->get();
            $store->product = $product;
            
            $status = true;
            return response()->json(['status'=>$status,'result'=>$store],200);
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function get_rfq_request(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();
            $store_id = $store->store_id;

            $rfq = DB::table('rfq_request as a')
                    ->select('b.email', 'b.full_name','a.*')
                    ->join('user as b', 'a.user_id', '=', 'b.user_id')
                    ->where('a.user_id','<>', $user_id)
                    ->where('status',"0")
                    ->where('request_expired','>',DB::raw('now()'))
                    ->whereNotExists(function($query)  use ($store_id)
                    {
                        $query->select(DB::raw(1))
                            ->from('rfq_offer')
                            ->whereRaw('rfq_offer.rfq_request_id = a.rfq_request_id')
                            ->whereRaw('rfq_offer.store_id = '.$store_id);
                    })
                    ->get();

            foreach ($rfq as $r) {
                $photo = DB::table('rfq_request_files')
                        ->select('file_path')
                        ->where('rfq_request_id',$r->rfq_request_id)
                        ->first();
                $r->photo = $photo;
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

    public function add_rfq_offer (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;
            $store = DB::table('view_user_store')->where('user_id',$user_id)->first();
            $store_id = $store->store_id;

            $rfq = new RFQ_Offer();
            $rfq->rfq_request_id = $request->rfq_request_id;
            $rfq->store_id = $store_id;
            $rfq->description = $request->description;
            $rfq->price_unit = $request->price_unit;
            $rfq->weight_unit = $request->weight_unit;
            $rfq->save();

            $rfq_offer_id = $rfq->rfq_offer_id;

            $photo = $request->file('photo');
            if ($photo) {
                $photo_path = $photo->storeAs('rfq/offer', $rfq_offer_id."_photo.".$photo->getClientOriginalExtension() , 'public');
                
                DB::table('rfq_offer_files')->insert([
                    'rfq_offer_id' => $rfq_offer_id, 
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

    public function get_user_store_detail(Request $request)
    {
        $stat = true;
        try {
            $jwt = $request->token;
            $user_id = null;

            if ($jwt) {
                $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
                $user_id = $decoded->data->user_id;
            }
        }
        catch(Exception $e) {
            $stat = false;
        }
            
        try {
            $store_id = $request->store_id;
            $store = DB::table('view_store_active')
                    ->select('*')
                    ->where('store_id',$store_id)
                    ->first();

            if($store == null){
                 return response()->json(['status'=>false, 'message'=>"Store Doesn't exist"],200);
            }
            else{
                $favorite_status = false;

                $courier_service = DB::table('store_courier_service as a')
                                ->join('master_courier as b', 'a.courier_id', '=', 'b.courier_id')
                                ->select(DB::raw('a.courier_id,b.courier_name,b.alias_name,b.logo'))
                                ->where('a.store_id',$store_id)
                                ->get();

                $store->courier_service =$courier_service;
                $product = DB::table('view_product')
                            ->select(DB::raw('product_id,product_name,photo,store_name,average_rating'))
                            ->where('store_id',$store_id)
                            ->where('product_type','0')
                            ->where('product_active_status','1')
                            ->get();
                $store->product = $product;
                
                if ($stat) {
                    $count = DB::table('favorite_store')
                            ->select('*')
                            ->where("user_id" , $user_id)
                            ->where("store_id" , $store_id)
                            ->count();
                    if ($count > 0) {
                        $favorite_status = true;
                    }
                }

                $status = true;
                return response()->json(['status'=>$status,'result'=>$store,'favorite_status'=>$favorite_status],200);
                
            }

            
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }
}
