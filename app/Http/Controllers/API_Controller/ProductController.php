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

class ProductController extends Controller
{
    private $jwt_key;
    public function __construct(){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }

    public function get_product_detail(Request $request)
    {
        $product_id = $request->product_id;
        $product = DB::table('view_product')->where('product_id',$product_id)->first();
        if ($product == null)
        {
            return response()->json(['status'=>false, 'message'=>"Product Doesn't exist"],200);
        }
        else {
            if ($product->product_active_status == "1") {
                $store_id = $product->store_id;

                //
                $product->rating = 0.0;
                $product->sold = 0;
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

                $store = DB::table('view_store_active')
                        ->where("store_id" , $store_id)
                        ->first();

                //
                $store->sold = 0;
                $store->transaction = 0;

                $courier = DB::table('view_store_courier')
                            ->select('*')
                            ->where("store_id" , $store_id)
                            ->get();

                $store->courier_service = $courier;

                return response()->json(['status'=>true, 'product_info'=>$product, 'store_info'=>$store],200);
            }
            else {
                return response()->json(['status'=>false, 'message'=>"Product NonActive"],200);
            }
        }
    }
}
