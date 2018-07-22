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

use App\User;

class UserController extends Controller
{
    private $user;
    private $jwt_key;
    public function __construct(User $user){
        $this->user = $user;
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }
    
    public function register(Request $request)
    {
        try 
        {
            $user_dbase = DB::table('user')->where('email',$request->email)->count();
            if ($user_dbase > 0) {
                return response()->json(['status'=>false,'message'=>'Email already exist'],200);
            }

            else {
                $user = $this->user->create([
                  'full_name' => $request->get('full_name'),
                  'email' => $request->get('email'),
                  'password' => bcrypt($request->get('password')),
                    'gender' => $request->get('gender'),
                    'phone_number' => $request->get('phone_number'),
                    'balance' => 0,
                    'active_status' => '1'
                ]);
            }
        }
        catch(Exception $error)
        {
            return response()->json(['error'=>'something went wrong, try again later'],500);
        }
        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user],200);
    }
    
    public function login(Request $request)
    {
        $token = null;
        try {
            $user_dbase = DB::table('user')->where('email',$request->email)->first();
            if (!$user_dbase) {
                return response()->json(['status'=>false,'message'=>'User Not Found']);
            }
            else {
                $pass_dbase = $user_dbase->password;
                if(!Hash::check($request->password, $pass_dbase))
                {
                    return response()->json(['status'=>false,'message'=>'Invalid Credentials']);
                }
                else
                {
                    if ($user_dbase->active_status == '2')
                    {
                        return response()->json(['status'=>false,'message'=>'User Non-Active']);
                    }
                    else {
                        try {
                            $expire  = time() + 86400;
                            $data = array(
                                'exp'  => $expire,           // Expire
                                'data' => [                  // Data related to the signer user
                                    'user_id'   => $user_dbase->user_id,
                                    'email'   => $user_dbase->email,
                                ]
                            );
                            $jwt = JWT::encode($data, $this->jwt_key);
                            return response()->json(['status'=>true,'jwt'=>$jwt],200);
                        }
                        catch (\Exception $error) {
                            return response()->json(['status'=>false,'message'=>'failed_to_create_token'], 500);
                        }
                    }
                }
            }
        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage()],500);
        }
    }

    public function getAuthUser (Request $request) {
        $jwt = $request->token;
        try {
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user = DB::table('user')
                    ->select('user_id', 'email', 'full_name', 'gender', 'phone_number',DB::raw('CASE WHEN COALESCE(avatar,"") = "" THEN "profile_image/default.png" ELSE avatar END as avatar, balance'))
                    ->where('user_id',$decoded->data->user_id)
                    ->first();
        }
        catch(Exception $error)
        {
            return response()->json(['error'=>$error->getMessage()],500);
        }
        return response()->json(['status' => true, 'result' => $user], 200);
    }

     public function update_user_profile (Request $request)
    {
        try {
            $jwt = $request->token;
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $user_id = $decoded->data->user_id;

            $user_count = DB::table('view_user_store')->where('user_id',$user_id)->count();

            if ($user_count == 0) {
                $status = false;
                $message = "You don't have privilege";
            }
            else{
                DB::beginTransaction();
                try{
                    $full_name = $request->full_name;
                    $store_name = $request->store_name;

                    $business_type = $request->business_type;
                    $established_year = $request->established_year;
                    $province = $request->province;
                    $city = $request->city;
                    $contact_person_name = $request->contact_person_name;
                    $contact_person_job_title = $request->contact_person_job_title;
                    $contact_person_phone_number = $request->contact_person_phone_number;
                    $description = $request->description;

                   

                    $user = DB::table('store')
                            ->where('store_id',$store_id)
                            ->update(
                                [
                                    'business_type' => $business_type,
                                    'established_year' => $established_year,
                                    'province' => $province,
                                    'city' => $city,
                                    'contact_person_name' =>$contact_person_name,
                                    'contact_person_job_title' =>$contact_person_job_title,
                                    'contact_person_phone_number' =>$contact_person_phone_number,
                                    'description'=>$description,
                                    'photo'=>$photo_path,
                                    'banner'=>$banner_path
                                ]
                            );

                    DB::commit();
                    $status = true;
                    $message = "Update Store Information Successfully";

                }
                catch(Exception $error) {
                    DB::rollback();
                    $status = false;
                    $message = $error->getMessage();
                }


            }
            
           

        }
        catch(Exception $error)
        {
           return response()->json(['error'=>$error],500);
        }
        return response()->json(['status'=>$status,'message'=>$message],200);
    }
}
