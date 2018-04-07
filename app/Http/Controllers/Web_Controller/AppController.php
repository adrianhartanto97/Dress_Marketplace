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

class AppController extends Controller
{
    private $jwt_key;
    private $login_info;
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
                $response = $client->post('http://localhost/dress_marketplace/api/get_auth_user', [
                    'form_params' => [
                        'token' => $jwt
                    ]
                ]);
            }
            catch (Exception $e) {
                $login_status = false;
            }

            $body = json_decode($response->getBody());
            $status = $body->status;
            if ($body->status != true) {
                $login_status = false;
            }

            else {
                $user_info = $body->result;
            }  
        }
        else {
            $login_status = false;
        }

        $result = new stdClass();
        $result->login_status = $login_status;
        $result->user_info = $user_info;

        return $result;
    }

    public function index(Request $request)
    {
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);
        return view('pages.index', ['login_info' => $login_info, 'login' => 'Adrianzz']);
    }
}