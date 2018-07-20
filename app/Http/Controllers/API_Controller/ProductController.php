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
use App\Favorite_Store;

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
                        ->select('a.created_at as wishlist_created_at ', 'b.*', 'b.average_rating as rating')
                        ->where('a.user_id',$user_id)
                        ->get();
            $status = true;

            return response()->json(['status'=>$status,'result'=>$wishlist],200);
        }
        catch(Exception $error) {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }
    }

    public function add_to_favorite (Request $request)
    {
        try {
            $store_id = $request->store_id;
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            DB::beginTransaction();
            $favorite = new Favorite_Store();
            $favorite->user_id = $user_id;
            $favorite->store_id = $store_id;
            
            $favorite->save();
            DB::commit();
            $status = true;
            $message = "Favorite Store Successfully";
        }
        catch (Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function delete_from_favorite (Request $request)
    {
        try {
            $store_id = $request->store_id;
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            DB::beginTransaction();
            DB::table('favorite_store')
            ->where("user_id" , $user_id)
            ->where("store_id" , $store_id)
            ->delete();
            
            DB::commit();
            $status = true;
            $message = "Remove Favorite Store Successfully";
        }
        catch (Exception $error)
        {
            DB::rollback();
            $status = false;
            $message = $error->getMessage();
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }

    public function my_favorite(Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $favorite = DB::table('favorite_store as a')
                        ->join('view_store_active as b', 'a.store_id', '=', 'b.store_id')
                        ->select('a.created_at as favorite_created_at ', 'b.*', 'b.rating as rating')
                        ->where('a.user_id',$user_id)
                        ->get();
            $status = true;

            return response()->json(['status'=>$status,'result'=>$favorite],200);
        }
        catch(Exception $error) {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$favorite],200);
        }
    }

    public function get_new_product_detail(Request $request)
    {
        $product = DB::table('view_product_detail_first_price')
                    ->select('*')
                    ->where("product_active_status" , "1")
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();

        if ($product == null)
        {
            return response()->json(['status'=>false, 'product_info'=>"Product Doesn't exist"],200);
        }
        else {
            return response()->json(['status'=>true, 'product_info'=>$product],200);
            
        }
    }

    public function best_seller_product_detail(Request $request)
    {
        $product = DB::table('view_product_detail_first_price')
                    ->select('*')
                    ->where("product_active_status" , "1")
                    ->orderBy('sold')
                    ->limit(4)
                    ->get();

        if ($product == null)
        {
            return response()->json(['status'=>false, 'product_info'=>"Product Doesn't exist"],200);
        }
        else {
            return response()->json(['status'=>true, 'product_info'=>$product],200);
            
        }
    }

    public static function search(Request $request)
    {
        try{
            $product_name = $request->product_name;
            $min_order =$request->min_order;
            $price_min=$request->price_min;
            $price_max=$request->price_max;
            $rating_min=$request->rating_min;
            $rating_max=$request->rating_max;
            $province=$request->province;
            $city=$request->city;
            $shipping=$request->shipping;
            $sort_by=$request->sort_by;

            $product = DB::table('view_product')
                    ->select('*')
                    ->where("product_active_status" , "1")
                    ->where('product_name', 'like', '%' .$product_name. '%')
                    ->get();
            $all = DB::table('view_product')
                    ->select('*')
                    ->where("product_active_status" , "1")
                    ->get();
            $count_product = count($product);
            $count_all = count($all);

            $status = true;
           
            return response()->json(['status'=>$status, 'product_info'=>$product, 'query'=>$product_name,'count'=>$count_product,'count_all'=>$count_all],200);
                
           
           

        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }

    }

    public static function advance_search(Request $request)
    {
        try{
            $min_order =$request->min_order;
            $price_min=$request->price_min;
            $price_max=$request->price_max;
            $rating_min=$request->rating_min;
            $rating_max=$request->rating_max;
            $province=$request->province;
            $city=$request->city;
            $courier_id=$request->courier_id;
            
            $product = DB::table('view_filter_courier')
                        ->select('*')
                        ->where('min_order', '>=', $min_order)
                        ->where('product_rating', '>=', $rating_min)
                        ->where('product_rating', '<=', $rating_max)
                        ->where('max_price', '>=', $price_min)
                        ->where('max_price', '<=', $price_max)
                        ->where('province', '=', $province)
                        ->where('city', '=', $city)
                        ->where('courier_id', '=', $courier_id)
                        ->get();
            $all = DB::table('view_product')
                        ->select('*')
                        ->where("product_active_status" , "1")
                        ->get();

            $count_product = count($product);
            $count_all = count($all);
            $status = true;

             return response()->json(['status'=>$status, 'product_info'=>$product,'count'=>$count_product,'count_all'=>$count_all],200);
                

        }
        catch(Exception $error){
             $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }

    }

    public function sort_by_asc(Request $request)
    {
        try{
            $product = DB::table('view_product')
                    ->select('*')
                    ->where("product_active_status" , "1")
                    ->orderBy("created_at","asc")
                    ->get();
            $status = true;
           
            return response()->json(['status'=>$status, 'product_info'=>$product],200);
                
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }

    }

     public function sort_by_desc(Request $request)
    {
        try{
            $product = DB::table('view_product')
                    ->select('*')
                    ->where("product_active_status" , "1")
                    ->orderBy("created_at","desc")
                    ->get();
            $status = true;
           
            return response()->json(['status'=>$status, 'product_info'=>$product],200);
                
        }
        catch(Exception $error)
        {
            $status = false;
            $message = $error->getMessage();
            return response()->json(['status'=>$status,'message'=>$message],200);
        }

    }

}
