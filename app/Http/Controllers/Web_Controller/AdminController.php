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

    public function manage_product (Request $request)
    {
        $pending_product = DB::table('view_product')
                            ->select('*')
                            ->where("product_type" , "0")
                            ->where("product_active_status" , "0")
                            ->where("product_ownership" , "0")
                            ->get();

        foreach ($pending_product as $p) {
            $price = DB::table('product_price')
                    ->select('*')
                    ->where("product_id" , $p->product_id)
                    ->get();

            $size =  DB::table('product_size')
                    ->join('product_size_attribute', 'product_size.size_id', '=', 'product_size_attribute.size_id')
                    ->select('product_size.size_id', 'product_size_attribute.size_name')
                    ->where("product_id" , $p->product_id)
                    ->get();
            $p->price = $price;
            $p->size = $size;
        }

        return view('pages.admin.admin_panel_manage_product',['active_nav' => "manage_product", 'pending_product' => $pending_product]);
        //print_r($pending_product);
    }

    public function accept_product (Request $request) 
    {
        $message = "success";
        $status = true;
        try {
            DB::table('product')
            ->where('product_id', $request->product_id)
            ->update(['product_active_status' => '1']);
            }
        catch (Exception $e) {
            $status = false;
            print_r($e->getMessage());
        }
        return response()->json(['status' => $status, 'message' => $message], 200);
    }

    public function reject_product (Request $request) 
    {
        $message = "success";
        $status = true;
        try {
            DB::table('product')
            ->where('product_id', $request->product_id)
            ->update(['product_active_status' => '2', 'reject_comment' => $request->reject_comment]);
            }
        catch (Exception $e) {
            $status = false;
            print_r($e->getMessage());
        }
        return response()->json(['status' => $status, 'message' => $message], 200);
    }

    public function verify_payment(Request $request)
    {
        $payment = DB::table('view_sales_transaction_payment as a')
                    ->join('user as b', 'a.user_id', '=', 'b.user_id')
                    ->join('company_bank_account as c', 'a.company_bank_id', '=', 'c.bank_id')
                    ->select('a.*', 'b.email', 'b.full_name', 'c.bank_name', 'c.account_number')
                    ->Where('a.payment_status', 'Payment Confirmation Sent')
                    ->get();
        

        return view('pages.admin.admin_panel_verify_payment',['active_nav' => "verify_payment", 'payment' => $payment]);
    }

    public function accept_payment (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->cookie('jwt');
            $transaction_id = $request->transaction_id;
            $receive_amount = $request->receive_amount;
            $transaction = DB::table('view_sales_transaction_payment')
                            ->where('transaction_id', $transaction_id)
                            ->first();
            $invoice_grand_total = $transaction->invoice_grand_total;
            $user_id = $transaction->user_id;

            DB::table('sales_transaction_payment')
            ->where('transaction_id', $transaction_id)
            ->update(
                [
                    'receive_amount' => $receive_amount, 
                    'status' => '1'
                ]
            );

            DB::table('sales_transaction_state')
            ->where('transaction_id', $transaction_id)
            ->update(
                [ 
                    'state' => '2'
                ]
            );

            $dif = $receive_amount - $invoice_grand_total;
            if ($dif > 0){
                DB::table('user')
                ->where('user_id', $user_id)
                ->update(['balance' => DB::raw("balance + ".$dif)]);
            }

            DB::commit();
            $status= true;
            $message = "success";
        }
        catch (Exception $e) {
            DB::rollback();
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(['status' => $status, 'message' => $message], 200);
    }

    public function reject_payment (Request $request)
    {
        DB::beginTransaction();
        try {
            $jwt = $request->cookie('jwt');
            $transaction_id = $request->transaction_id;
            $receive_amount = $request->receive_amount;
            $transaction = DB::table('view_sales_transaction_payment')
                            ->where('transaction_id', $transaction_id)
                            ->first();
            $invoice_grand_total = $transaction->invoice_grand_total;
            $user_id = $transaction->user_id;

            DB::table('sales_transaction_payment')
            ->where('transaction_id', $transaction_id)
            ->update(
                [
                    'receive_amount' => $receive_amount, 
                    'status' => '2',
                    'reject_comment' => $request->reject_comment
                ]
            );

            DB::table('user')
            ->where('user_id', $user_id)
            ->update(['balance' => DB::raw("balance + ".$receive_amount)]);
            

            DB::commit();
            $status= true;
            $message = "success";
        }
        catch (Exception $e) {
            DB::rollback();
            $status = false;
            $message = $e->getMessage();
        }

        return response()->json(['status' => $status, 'message' => $message], 200);
    }
}
