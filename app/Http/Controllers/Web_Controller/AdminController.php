<?php

namespace App\Http\Controllers\Web_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use \Firebase\JWT\JWT;
use \Exception;
use \stdClass;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    private $jwt_key;
    private $login_info;
    private $base_url = 'http://localhost/dress_marketplace/api/';
    public function __construct(Request $request){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }

    public function login_page() {
        return view('pages.admin.login');
    }

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        
        $client = new Client();
        if ($email == "admin" && $password == "admin") {
            $expire  = time() + 86400;
            $data = array(
                'exp'  => $expire,           // Expire
                'data' => [                  // Data related to the signer user
                    'admin_id'   => 'admin'
                ]
            );
            $jwt = JWT::encode($data, $this->jwt_key);
            $cookie = cookie()->forever('admin_jwt', $jwt);

            return redirect('admin/manage_store')->withCookie($cookie);
        }
        else {
            $message = "Invalid Credentials";
            return Redirect::back()->with('status' , $message);
        }         
    }

    public function logout() {
        $cookie = \Cookie::forget('admin_jwt');
        return redirect('admin_login_page')->withCookie($cookie);
    }

    public function manage_store (Request $request)
    {
        $pending_store = DB::table('view_store_pending')->get();
        return view('pages.admin.admin_panel_manage_store',['active_nav' => "manage_store", 'pending_store' => $pending_store]);
    }

    public function accept_store (Request $request) 
    {
        $message = "success";
        $status = true;
        try {
            DB::table('store')
            ->where('store_id', $request->store_id)
            ->update(['store_active_status' => '1']);
            }
        catch (Exception $e) {
            $status = false;
            print_r($e->getMessage());
        }
        return response()->json(['status' => $status, 'message' => $message], 200);
    }

    public function reject_store (Request $request) 
    {
        $message = "success";
        $status = true;
        try {
            DB::table('store')
            ->where('store_id', $request->store_id)
            ->update(['store_active_status' => '2', 'reject_comment' => $request->reject_comment]);
            }
        catch (Exception $e) {
            $status = false;
            print_r($e->getMessage());
        }
        return response()->json(['status' => $status, 'message' => $message], 200);
    }

    public function manage_user (Request $request)
    {
        $active_user = DB::table('user')
        ->select('user_id', 'email', 'full_name', DB::raw('CASE WHEN COALESCE(avatar,"") = "" THEN "profile_image/default.png" ELSE avatar END as avatar'))
        ->where(DB::raw('COALESCE(active_status,"1")') , "1")
        ->get();

        $nonactive_user = DB::table('user')
        ->select('user_id', 'email', 'full_name', DB::raw('CASE WHEN COALESCE(avatar,"") = "" THEN "profile_image/default.png" ELSE avatar END as avatar'))
        ->where('active_status' , "2")
        ->get();
        return view('pages.admin.admin_panel_manage_user',['active_nav' => "manage_user", 'active_user' => $active_user, 'nonactive_user' => $nonactive_user]);
    }

    public function set_nonactive_user (Request $request) 
    {
        $message = "success";
        $status = true;
        try {
            DB::table('user')
            ->where('user_id', $request->user_id)
            ->update(['active_status' => '2']);
            }
        catch (Exception $e) {
            $status = false;
            print_r($e->getMessage());
        }
        return response()->json(['status' => $status, 'message' => $message], 200);
    }

    public function set_active_user (Request $request) 
    {
        $message = "success";
        $status = true;
        try {
            DB::table('user')
            ->where('user_id', $request->user_id)
            ->update(['active_status' => '1']);
            }
        catch (Exception $e) {
            $status = false;
            print_r($e->getMessage());
        }
        return response()->json(['status' => $status, 'message' => $message], 200);
    }
}
