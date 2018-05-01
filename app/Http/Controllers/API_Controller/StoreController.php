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
                        $photo->storeAs('Store/photo', $request->store_name."_photo.".$photo->getClientOriginalExtension() , 'public');
                    }

                    $banner = $request->file('banner');
                    if ($banner) {
                        $banner->storeAs('Store/banner', $request->store_name."_banner.".$banner->getClientOriginalExtension() , 'public');
                    }

                    $store->save();

                    $store_id = $store->store_id;
                    $store_bank_account = new Store_Bank_Account();
                    $store_bank_account->store_id = $store_id;
                    $store_bank_account->bank_name = $request->bank_name;
                    $store_bank_account->branch = $request->branch;
                    $store_bank_account->bank_account_number = $request->bank_account_number;
                    $store_bank_account->name_in_bank = $request->name_in_bank_account;

                    $store_courier_service = new Store_Courier_Service();
                    $store_courier_service->store_id = $store_id;
                    $store_courier_service->courier_id= $request->courier;

                    DB::commit();
                    $status = true;
                    $message = "Store registered successfully ";
                }

                catch(Exception $error) {
                    DB::rollback();
                    $status = false;
                    $message = $error;
                }
            }
        }
        catch(Exception $error) {
            return response()->json(['error'=>$error],500);
        }

        return response()->json(['status'=>$status,'message'=>$message],200);
    }
}
