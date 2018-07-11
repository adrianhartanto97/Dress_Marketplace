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
use App\Store_Courier_Service;
use App\Product;
use App\Product_Size;
use App\Product_Price;
use App\Wishlist;

class ProductController extends Controller
{
    private $jwt_key;
    public function __construct(){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }

    public function get_product_detail(Request $request)
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
            
            $product_id = $request->product_id;
            $product = DB::table('view_product')->where('product_id',$product_id)->first();
            if ($product == null)
            {
                return response()->json(['status'=>false, 'message'=>"Product Doesn't exist"],200);
            }
            else {
                if ($product->product_active_status == "1") {
                    $store_id = $product->store_id;
                    $wishlist_status = false;

                    //
                    $product->rating = $product->average_rating;
                    // $product->sold = 0;
                    //
                    
                    $size =  DB::table('product_size')
                                ->join('product_size_attribute', 'product_size.size_id', '=', 'product_size_attribute.size_id')
                                ->select('product_size.size_id', 'product_size_attribute.size_name')
                                ->where("product_id" , $product_id)
                                ->get();
                    $product->size = $size;

                    $price = DB::table('product_price')
                                ->select('*')
                                ->where("product_id" , $product_id)
                                ->get();
                    
                    $product->price = $price;

                    $downline_partner = DB::table('view_downline_partner')
                                        ->select('*')
                                        ->where("product_id" , $product_id)
                                        ->get();
                    $product->downline_partner = $downline_partner;

                    if ($product->product_ownership == '1')
                    {
                        $product->is_partnership = true;
                        $upline = DB::table('view_upline_partner')
                                    ->select('*')
                                    ->where("product_id_partner" , $product_id)
                                    ->first();
                        $product->upline_partner = $upline;
                    }
                    else {
                        $product->is_partnership = false;
                    }

                    $review_rating = DB::table('view_product_review_rating')
                                    ->select('*')
                                    ->where("product_id" , $product_id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

                    $product->review_rating = $review_rating;

                    $store = DB::table('view_store_active')
                            ->where("store_id" , $store_id)
                            ->first();

                    //
                    // $store->sold = 0;
                    // $store->transaction = 0;

                    $courier = DB::table('view_store_courier')
                                ->select('*')
                                ->where("store_id" , $store_id)
                                ->get();

                    $store->courier_service = $courier;

                    if ($stat) {
                        $count = DB::table('wishlist')
                                ->select('*')
                                ->where("user_id" , $user_id)
                                ->where("product_id" , $product_id)
                                ->count();
                        if ($count > 0) {
                            $wishlist_status = true;
                        }
                    }

                    return response()->json(['status'=>true, 'product_info'=>$product, 'store_info'=>$store, 'wishlist_status'=>$wishlist_status],200);
                }
                else {
                    return response()->json(['status'=>false, 'message'=>"Product NonActive"],200);
                }
            }
        
        
    }

    public function add_to_wishlist (Request $request)
    {
        try {
            $product_id = $request->product_id;
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            DB::beginTransaction();
            $wishlist = new Wishlist();
            $wishlist->user_id = $user_id;
            $wishlist->product_id = $product_id;
            
            $wishlist->save();
            DB::commit();
            $status = true;
            $message = "Product added to Wishlist Successfully";
        }
        catch (Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function delete_from_wishlist (Request $request)
    {
        try {
            $product_id = $request->product_id;
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            DB::beginTransaction();
            DB::table('wishlist')
            ->where("user_id" , $user_id)
            ->where("product_id" , $product_id)
            ->delete();
            
            DB::commit();
            $status = true;
            $message = "Product deleted from wishlist";
        }
        catch (Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function my_wishlist(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $wishlist = DB::table('wishlist as a')
                        ->join('view_product as b', 'a.product_id', '=', 'b.product_id')
                        ->select('a.created_at as wishlist_created_at ', 'b.*')
                        ->where('a.user_id',$user_id)
                        ->get();
            $status = true;

            foreach ($wishlist as $w){
                $w->rating = 0.0;
            }

            return response()->json(['status'=>$status,'result'=>$wishlist],200);
        }
        catch(Exception $error) {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }
}
