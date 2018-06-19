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
use Illuminate\Support\Facades\Session;

class App2Controller extends Controller
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
        $user_store_info = new stdClass();
        $user_cart_info = new stdClass();
        $user_wishlist_info = new stdClass();
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

            try {
                $user_store = $client->post($this->base_url.'get_user_store', [
                    'form_params' => [
                        'token' => $jwt
                    ]
                ]);
                $user_store_info = json_decode($user_store->getBody());
            }
            catch (Exception $e) {
                $login_status = false;
            }

            try {
                $user_cart = $client->post($this->base_url.'view_shopping_bag', [
                    'form_params' => [
                        'token' => $jwt
                    ]
                ]);
                $user_cart_info = json_decode($user_cart->getBody());
            }
            catch (Exception $e) {
                $login_status = false;
            }
            try {
                $user_wishlist = $client->post($this->base_url.'my_wishlist', [
                    'form_params' => [
                        'token' => $jwt
                    ]
                ]);
                $user_wishlist_info = json_decode($user_wishlist->getBody());
            }
            catch (Exception $e) {
                $login_status = false;
            }
        }
        else {
            $login_status = false;
        }

        $result = new stdClass();
        $result->login_status = $login_status;
        $result->user_info = $user_info;
        $result->user_store_info = $user_store_info;
        $result->user_cart_info = $user_cart_info;
        $result->user_wishlist_info = $user_wishlist_info;
        return $result;
    }

    public function open_wishlist_page(){
       return view('pages.wishlist');
    }

    public function add_to_wishlist(Request $request){
        $product_id= $request->product_id;
        $jwt = $request->cookie('jwt');

    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'add_to_wishlist', [
                'form_params' => [
                    'token' => $jwt,
                    'product_id' => $product_id,
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
     }

     
 
     public function delete_from_wishlist (Request $request)
     {
         $product_id= $request->product_id;
         $jwt = $request->cookie('jwt');
 
         $client = new Client();
         try {
             $res = $client->post($this->base_url.'delete_from_wishlist', [
                 'form_params' => [
                     'token' => $jwt,
                     'product_id' => $product_id
                 ]
             ]);
 
             $body = json_decode($res->getBody());
 
             return Redirect::back()->with('status', $body->status)->with('message', $body->message);
         }
 
         catch (Exception $e) {
             echo $e->getMessage();
         }
     }

     public function my_wishlist (Request $request)
     {
         $jwt = $request->cookie('jwt');
 
         $login_info = $this->get_login_info($jwt);
 
         $client = new Client();
         try {
             $user_wishlist = $client->post($this->base_url.'my_wishlist', [
                 'form_params' => [
                     'token' => $jwt
                 ]
             ]);
             $result = json_decode($user_wishlist->getBody());
 
             return view('pages.wishlist', ['login_info' => $login_info, 'result' => $result]);
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
     }
}
