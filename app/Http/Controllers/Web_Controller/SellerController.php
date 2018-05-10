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

class SellerController extends Controller
{
    private $jwt_key;
    private $login_info;
    private $base_url = 'http://localhost/dress_marketplace/api/';
    public function __construct(Request $request){
        $this->jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    }

    private function get_login_info($jwt) {
        $login_status = true;
        $user_info = new stdClass();
        $client = new Client();
        if ($jwt) {
            try{
                // $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
                //$user_info = $decoded->data;
                $response = $client->post($this->base_url.'get_auth_user', [
                    'form_params' => [
                        'token' => $jwt
                    ]
                ]);
                $body = json_decode($response->getBody());
                $status = $body->status;
                if ($body->status != true) {
                    $login_status = false;
                }

                else {
                    $user_info = $body->result;
                } 
            }
            catch (Exception $e) {
                $login_status = false;
            }

            // $body = json_decode($response->getBody());
            // $status = $body->status;
            // if ($body->status != true) {
            //     $login_status = false;
            // }

            // else {
            //     $user_info = $body->result;
            // }  
        }
        else {
            $login_status = false;
        }

        $result = new stdClass();
        $result->login_status = $login_status;
        $result->user_info = $user_info;

        return $result;
    }

    private function check_user_store ($jwt) {
        $store = null;

        try {
            $client = new Client();
            $response = $client->post($this->base_url.'get_user_store', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $body = json_decode($response->getBody());
            
            if ($body->have_store == true) {
                $store = $body->store;
            }
        }
        catch(Exception $e) {

        }
             
        return $store;
    }

    public function seller_panel_dashboard (Request $request) 
    {
        $jwt = $request->cookie('jwt');
        $store = $this->check_user_store($jwt);

        if ($store) {
            $login_info = $this->get_login_info($jwt);
            return view('pages.seller_panel_dashboard', ['login_info' => $login_info,'store_info' => $store, 'active_nav' => 'dashboard']);
        }
        else {
            return redirect('index');
        }
    }

    public function seller_panel_store_settings (Request $request) 
    {
        $jwt = $request->cookie('jwt');
        $store = $this->check_user_store($jwt);

        if ($store) {
            $login_info = $this->get_login_info($jwt);
            return view('pages.seller_panel_store_settings', ['login_info' => $login_info,'store_info' => $store, 'active_nav' => 'store_settings']);
        }
        else {
            return redirect('index');
        }
    }

    public function seller_panel_product (Request $request) {
        $jwt = $request->cookie('jwt');
        $store = $this->check_user_store($jwt);
        $dress_attributes = null;
        try {
            $client = new Client();
            $res = $client->post($this->base_url.'get_dress_attributes', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $dress_attributes = json_decode($res->getBody());
        }
        catch(Exception $e) {

        }

        if ($store) {
            $login_info = $this->get_login_info($jwt);
            return view('pages.seller_panel_product', ['login_info' => $login_info,'store_info' => $store, 'active_nav' => 'products', 'dress_attributes' => $dress_attributes]);
            
        }
        else {
            return redirect('index');
        }
    }

    public function test(Request $request) {
        $size = $request->size;
        $price = $request->price_range;
        $size[1] = (int)$size[1];
        var_dump($price);
    }
}
