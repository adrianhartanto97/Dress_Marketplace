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
use App\Param_Settings;

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

    

     public function manage_ffa_psnn (Request $request)
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

        return view('pages.admin.admin_panel_manage_ffa_psnn',['active_nav' => "algo", 'pending_product' => $pending_product]);
        //print_r($pending_product);
    }

    private function sigmoid_bipolar($x) {
        // return (exp($x) - exp(-1*$x)) / (exp($x) + exp(-1*$x));
        return (1 - exp(-1*$x)) / (1 + exp(-1*$x));
    }

    public function submit_training(Request $request)
    {
        $n = 12;
        $jumlah_firefly = $request->n_firefly;
        $maks_epoch_ffa = $request->maks_epoch_ffa;
        $B0 = $request->base_beta;
        $g = $request->gamma;
        $a = $request->alpha;
        $maks_epoch_psnn = $request->maks_epoch_psnn;
        $J_sum = $request->summing_units;
        $LR = $request->learning_rate;
        $momentum = $request->momentum;
        $random_seed = time();

        
        try {
            $result = $this->algoritma_FFA_PSNN($random_seed, $jumlah_firefly, $maks_epoch_ffa, $B0, $g, $a, $maks_epoch_psnn, $J_sum, $LR, $momentum);
            
            DB::beginTransaction();

            DB::table('param_settings')->delete();
            DB::table('param_settings_weight_set')->delete();

            $param = new Param_Settings();
            $param->random_seed = $random_seed;
            $param->param_firefly = $jumlah_firefly;
            $param->param_maks_epoch_ffa = $maks_epoch_ffa;
            $param->param_base_beta = $B0;
            $param->param_gamma = $g;
            $param->param_alpha = $a;
            $param->param_maks_epoch_psnn = $maks_epoch_psnn;
            $param->param_summing_units = $J_sum;
            $param->param_learning_rate = $LR;
            $param->param_momentum = $momentum;
            $param->rmse = $result->rmse_terbaik;
            $param->save();

            $param_id = $param->id;

            
            for ($i = 0; $i <= $n; $i++) {
                for ($j = 1; $j <= $J_sum; $j++) {
                    DB::table('param_settings_weight_set')->insert([
                            'id' => $param_id, 
                            'node_i' => $i,
                            'node_j' => $j,
                            'weight' => $result->weight_terbaik[$i][$j]
                        ]
                    );
                }
            }
            
            DB::commit();
            return view('pages.admin.training_result',['result' => $result]);
        }
        catch(Exception $error)
        {
            DB::rollback();
            echo $error->getMessage();
        }
    }

    public function submit_testing(Request $request)
    {
        $n = 12;
        $jumlah_firefly = $request->n_firefly;
        $maks_epoch_ffa = $request->maks_epoch_ffa;
        $base_beta_min = $request->base_beta_min;
        $base_beta_max = $request->base_beta_max;
        $base_beta_step = $request->base_beta_step;
        $gamma_min = $request->gamma_min;
        $gamma_max = $request->gamma_max;
        $alpha_min = $request->alpha_min;
        $alpha_max = $request->alpha_max;
        $alpha_step = $request->alpha_step;
        $maks_epoch_psnn = $request->maks_epoch_psnn;
        $J_sum = $request->summing_units;
        $LR = $request->learning_rate;
        $momentum_min = $request->momentum_min;
        $momentum_max = $request->momentum_max;
        $momentum_step = $request->momentum_step;
        $random_seed = time();

        
        try {
            // $result = $this->algoritma_FFA_PSNN($random_seed, $jumlah_firefly, $maks_epoch_ffa, $B0, $g, $a, $maks_epoch_psnn, $J_sum, $LR, $momentum);
            
            // DB::beginTransaction();

            // DB::table('param_settings')->delete();
            // DB::table('param_settings_weight_set')->delete();

            // $param = new Param_Settings();
            // $param->random_seed = $random_seed;
            // $param->param_firefly = $jumlah_firefly;
            // $param->param_maks_epoch_ffa = $maks_epoch_ffa;
            // $param->param_base_beta = $B0;
            // $param->param_gamma = $g;
            // $param->param_alpha = $a;
            // $param->param_maks_epoch_psnn = $maks_epoch_psnn;
            // $param->param_summing_units = $J_sum;
            // $param->param_learning_rate = $LR;
            // $param->param_momentum = $momentum;
            // $param->rmse = $result->rmse_terbaik;
            // $param->save();

            // $param_id = $param->id;

            
            // for ($i = 0; $i <= $n; $i++) {
            //     for ($j = 1; $j <= $J_sum; $j++) {
            //         DB::table('param_settings_weight_set')->insert([
            //                 'id' => $param_id, 
            //                 'node_i' => $i,
            //                 'node_j' => $j,
            //                 'weight' => $result->weight_terbaik[$i][$j]
            //             ]
            //         );
            //     }
            // }
            
            // DB::commit();
            // return view('pages.admin.training_result',['result' => $result]);

            $stop_gamma = false;
            // $gamma_min = 1;
            // $gamma_max = 1;
            $gamma_current = $gamma_min;
            $string = "";
            while (!$stop_gamma) {
                $stop_beta = false;
                // $base_min = 0.1;
                // $beta_max = 1;
                $beta_current = $base_beta_min;
                // $beta_step = 0.2;
                while (!$stop_beta) {
                    $stop_alpha = false;
                    // $alpha_min = 0.1;
                    // $alpha_max = 0.2;
                    $alpha_current = $alpha_min;
                    // $alpha_step = 0.02;
                    while (!$stop_alpha) {
                        $stop_momentum = false;
                        // $momentum_min = 0.1;
                        // $momentum_max = 1;
                        $momentum_current = $momentum_min;
                        // $momentum_step = 0.2;
                        while (!$stop_momentum) {
                            echo $gamma_current." ".$beta_current." ".$alpha_current." ".$momentum_current."<br>";

                            //cek kriteria stop momentum
                            $momentum_current = round($momentum_current + $momentum_step,2);
                            if ($momentum_current > $momentum_max) {
                                $stop_momentum = true;
                            }
                        }

                        //cek kriteria stop alpha
                        $alpha_current = round($alpha_current + $alpha_step,2);
                        if ($alpha_current > $alpha_max) {
                            $stop_alpha = true;
                        }
                    }

                    //cek kriteria stop beta
                    $beta_current = round($beta_current + $base_beta_step,2);
                    if ($beta_current > $base_beta_max) {
                        $stop_beta = true;
                    }
                }

                //cek kriteria stop gamma
                if ($gamma_current >= 0.01 && $gamma_current < 0.10) {
                    $gamma_step = 0.01;
                }
                else if ($gamma_current >= 0.10 && $gamma_current < 1.00) {
                    $gamma_step = 0.1;
                }
                else if ($gamma_current >= 1.00 && $gamma_current < 10.00) {
                    $gamma_step = 1;
                }
                else {
                    $gamma_step = 10;
                }

                $gamma_current = round($gamma_current + $gamma_step,2);
                if ($gamma_current > $gamma_max) {
                    $stop_gamma = true;
                }
            }

        }
        catch(Exception $error)
        {
            DB::rollback();
            echo $error->getMessage();
        }
    }

    public function algoritma_FFA_PSNN($random_seed, $jumlah_firefly, $maks_epoch_ffa, $B0, $g, $a, $maks_epoch_psnn, $J_sum, $LR, $momentum ) {
        set_time_limit(86400);
        $data_raw = DB::table('data_training')->get();

        $intensitas_terbaik = -1;
        $indeks_terbaik = -1;
        $rmse_terbaik = 1;
        $true_counter_terbaik = 0;

        //inisialisasi parameter
        $total_data = 474;
        $string = "";
        $n = 12;
        //$J_sum = 3;
        //$maks_epoch_ffa = 2;
        //$maks_epoch_psnn = 5;
        //$LR = 0.05;
        //$jumlah_firefly = 3;
        //$B0 = 0.4; //base beta (koefisien ketertarikan awal untuk setiap kunang-kunang)
        //$g = 0.5; //gamma (koefisien penarik / pengundang kunang-kunang lain)
        //$a = 0.1; //alpha
        //$momentum = 0.5;

        srand($random_seed); 

        //inisialisasi dataset
        $data = array();
        for ($i = 0 ; $i<$total_data;$i++) {
            $data[$i] = array();
            $data[$i][0] = 1;
            $data[$i][1] = $this->sigmoid_bipolar($data_raw[$i]->style);
            $data[$i][2] = $this->sigmoid_bipolar($data_raw[$i]->price);
            $data[$i][3] = $this->sigmoid_bipolar($data_raw[$i]->rating);
            $data[$i][4] = $this->sigmoid_bipolar($data_raw[$i]->size);
            $data[$i][5] = $this->sigmoid_bipolar($data_raw[$i]->season);
            $data[$i][6] = $this->sigmoid_bipolar($data_raw[$i]->neck_line);
            $data[$i][7] = $this->sigmoid_bipolar($data_raw[$i]->sleeve_length);
            $data[$i][8] = $this->sigmoid_bipolar($data_raw[$i]->waist_line);
            $data[$i][9] = $this->sigmoid_bipolar($data_raw[$i]->material);
            $data[$i][10] = $this->sigmoid_bipolar($data_raw[$i]->fabric_type);
            $data[$i][11] = $this->sigmoid_bipolar($data_raw[$i]->decoration);
            $data[$i][12] = $this->sigmoid_bipolar($data_raw[$i]->pattern_type);
            $data[$i][13] = ($data_raw[$i]->recommendation);
            $data[$i][14] = $data_raw[$i]->dress_id;            
        }

        $daftar_firefly = array();
        //inisialisasi firefly
        for ($i = 0; $i < $jumlah_firefly; $i++) {
            $daftar_firefly[$i] = new stdClass();
            //init random weight
            $w = array();
            for ($k = 0; $k <= $n; $k++) {
                $w[$k] = array();
                $w_temp[$k] = array();
                for ($j = 1; $j <= $J_sum; $j++) {
                    $w[$k][$j] = rand (-1*100, 1*100) / 100;
                }
            }
            $daftar_firefly[$i]->w = $w;
            $daftar_firefly[$i]->intensitas = 0;
        }

        //hitung intensitas masing-masing firefly
        for ($i = 0; $i < $jumlah_firefly; $i++) {
            $daftar_firefly[$i] = $this->komputasi_psnn($data, $total_data, $daftar_firefly[$i], $maks_epoch_psnn, $J_sum, $LR, $n, $momentum);
            
            if ($daftar_firefly[$i]->intensitas > $intensitas_terbaik) {
                $intensitas_terbaik = $daftar_firefly[$i]->intensitas;
                $indeks_terbaik = $i;
            }
        }

        for ($e = 0; $e < $maks_epoch_ffa; $e++) {
            for ($i = 0; $i < $jumlah_firefly; $i++) { 
                for ($j = 0; $j < $jumlah_firefly; $j++) {
                    if ($daftar_firefly[$i]->intensitas < $daftar_firefly[$j]->intensitas) {
                        $r = 0.0;
                        for ($kk = 0; $kk <= $n; $kk++) {
                            for ($jj = 1; $jj <= $J_sum; $jj++) {
                                $r += ($daftar_firefly[$i]->w[$kk][$jj] - $daftar_firefly[$j]->w[$kk][$jj]) * ($daftar_firefly[$i]->w[$kk][$jj] - $daftar_firefly[$j]->w[$kk][$jj]);
                            }
                        }
                        $r = sqrt($r);

                        $beta = $B0 * exp((-1*$g) * $r * $r);

                        for ($kk = 0; $kk <= $n; $kk++) {
                            for ($jj = 1; $jj <= $J_sum; $jj++) {
                                $daftar_firefly[$i]->w[$kk][$jj] += $beta * ($daftar_firefly[$j]->w[$kk][$jj] - $daftar_firefly[$i]->w[$kk][$jj]);
                                $random = rand(0,100)/100;
                                $daftar_firefly[$i]->w[$kk][$jj] += $a * ($random - 0.5);

                                if ($daftar_firefly[$i]->w[$kk][$jj] > 1) {$daftar_firefly[$i]->w[$kk][$jj] = 1;}
                                if ($daftar_firefly[$i]->w[$kk][$jj] < -1) {$daftar_firefly[$i]->w[$kk][$jj] = -1;}
                            }
                        }

                        $daftar_firefly[$i] = $this->komputasi_psnn($data, $total_data, $daftar_firefly[$i], $maks_epoch_psnn, $J_sum, $LR, $n, $momentum);
                        
                        if ($daftar_firefly[$i]->intensitas > $intensitas_terbaik) {
                            $intensitas_terbaik = $daftar_firefly[$i]->intensitas;
                            $indeks_terbaik = $i;
                            $rmse_terbaik = $daftar_firefly[$i]->rmse;
                            $true_counter_terbaik = $daftar_firefly[$i]->true_counter;
                        }
                    }
                }
            }
        }

        $result = new stdClass();
        $result->intensitas_terbaik = $intensitas_terbaik;
        $result->indeks_terbaik = $indeks_terbaik;
        $result->rmse_terbaik = $rmse_terbaik;
        $result->true_counter_terbaik = $true_counter_terbaik;
        $result->weight_terbaik = $daftar_firefly[$indeks_terbaik]->w;

        return $result;
    }

    private function komputasi_psnn($data, $total_data, $firefly, $maks_epoch_psnn, $J_sum, $LR, $n, $momentum)
    {   
        $w_temp = array();
        $RMSE_terbaik = 1000000;
        $true_counter_terbaik = -1;
        $weight_terbaik = array();

        for ($e = 0; $e < $maks_epoch_psnn; $e++) {        
            for ($p = 0; $p < $total_data; $p++) {
                $h = array();
                $pi = 1;
                for ($j = 1; $j <= $J_sum; $j++) {
                    $h[$j] = 0;
                    for ($k = 0; $k <= $n; $k++) {
                        $h[$j] += ($firefly->w[$k][$j] * $data[$p][$k]);
                    }
                    $pi *= $h[$j];                 
                }

                //aktivasi sigmoid
                $ex = round(exp(-1*$pi), 10);
                $y = round(1 / (1.0 + $ex) , 10);

                if ($y == 0) {
                    $y=0.000000000000000000001;
                }

                for ($k = 0; $k <= $n; $k++) {
                    for ($l = 1; $l <= $J_sum; $l++) {
                        $delta = $LR * ($data[$p][13] - $y) * ((1.0-$y) * $y) * $data[$p][$k];
                        $hj = 0;
                        $pi_h = 1;

                        // for ($b = 0; $b <= $n; $b++) {
                        //     $hj += ($firefly->w[$b][$l] * $data[$p][$b]);
                        // }
                        $pi_h = $pi / $h[$l];
                        $delta = round($delta*$pi_h, 10);

                        $w_temp[$k][$l] = round($firefly->w[$k][$l] + ($delta * $momentum), 10);
                        if ($w_temp[$k][$l] > 1) {$w_temp[$k][$l] = 1;}
                        if ($w_temp[$k][$l] < -1) {$w_temp[$k][$l] = -1;}
                        //$string = $string." k : ".$k." , l : ".$l. " , delta : ".$w_temp[$k][$l]."<br>";
                        //$string = $string. "delta : ".$w_temp[$k][$l]."<br>";
                    }
                }
                
                for ($k = 0; $k <= $n; $k++) {
                    for ($j = 1; $j <= $J_sum; $j++) {
                        $firefly->w[$k][$j] = $w_temp[$k][$j];                
                    }
                }

                //hitung RMSE
                $nilai_kesalahan = 0;
                $y_temp = array();
                $true_counter=0;
                for ($pp = 0; $pp < $total_data; $pp++) {
                    $h = array();
                    $pi = 1;
                    for ($jj = 1; $jj <= $J_sum; $jj++) {
                        $h[$jj] = 0;
                        for ($kk = 0; $kk <= $n; $kk++) {
                            $h[$jj] += ($firefly->w[$kk][$jj] * $data[$pp][$kk]);
                        }
                        $pi *= $h[$jj];                 
                    }
                    //aktivasi sigmoid
                    $ex = round(exp(-1*$pi), 10);
                    $y = round(1 / (1.0 + $ex) , 10);

                    if ($y == 0) {
                        $y=0.000000000000000000001;
                    }
                    $y_temp[$pp] = $y;
                    if (round($y) == $data[$pp][13]) {
                        $true_counter++ ;
                    }

                    // if (round($y) <> $data[$pp][13] ) {
                    //     $nilai_kesalahan += (round($y) - $data[$pp][13]) * (round($y) - $data[$pp][13]);
                    // }
                    $nilai_kesalahan += ($y - $data[$pp][13]) * ($y - $data[$pp][13]);
                }
                $RMSE = sqrt($nilai_kesalahan/$total_data);

                if ($RMSE < $RMSE_terbaik) {
                    $RMSE_terbaik = $RMSE;
                    $true_counter_terbaik = $true_counter;
                    $weight_terbaik = $firefly->w;
                }                
            }
        }

        $firefly->intensitas = 1/$RMSE_terbaik;
        $firefly->w = $weight_terbaik;
        $firefly->true_counter = $true_counter_terbaik;
        $firefly->rmse = round($RMSE_terbaik,10);
        return $firefly;
    }
}
