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
use App\Cart;

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
}
