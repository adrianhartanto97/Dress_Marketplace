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

class StoreController extends Controller
{
    private $jwt_key;
    public function __construct(){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
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
}
