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

    public function add_product (Request $request)
    {
        try {
            $client = new Client();
            $jwt = $request->cookie('jwt');
            $photo_file = Input::file('photo');
            $multipart = [
                [
                    'name'     => 'token',
                    'contents' => $jwt
                ],
                [
                    'name'     => 'name',
                    'contents' => $request->name
                ],
                [
                    'name'     => 'min_order',
                    'contents' => $request->min_order
                ],
                [
                    'name'     => 'weight',
                    'contents' => $request->weight
                ],
                [
                    'name'     => 'description',
                    'contents' => $request->description
                ],
                [
                    'name'     => 'photo',
                    'contents' => fopen( $photo_file->getRealPath(), 'r'),
                    'filename' => 'photo.'.$photo_file->getClientOriginalExtension()
                ],
                [
                    'name'     => 'style_id',
                    'contents' => $request->style
                ],
                [
                    'name'     => 'season_id',
                    'contents' => $request->season
                ],
                [
                    'name'     => 'neckline_id',
                    'contents' => $request->neckline
                ],
                [
                    'name'     => 'sleevelength_id',
                    'contents' => $request->sleevelength
                ],
                [
                    'name'     => 'waiseline_id',
                    'contents' => $request->waiseline
                ],
                [
                    'name'     => 'material_id',
                    'contents' => $request->material
                ],
                [
                    'name'     => 'fabrictype_id',
                    'contents' => $request->fabrictype
                ],
                [
                    'name'     => 'decoration_id',
                    'contents' => $request->decoration
                ],
                [
                    'name'     => 'patterntype_id',
                    'contents' => $request->patterntype
                ],
                // [
                //     'name'     => 'price',
                //     'contents' => $request->price_range
                // ],
                // [
                //     'name'     => 'size',
                //     'contents' => $request->size
                // ]
            ];

            $size = $request->size;
            for ($i = 0; $i<count($size); $i++) {
                $array = [
                    'name'     => 'size['.$i.']',
                    'contents' => $size[$i]
                ];
                array_push($multipart, $array);
            }

            $price = $request->price_range;
            for ($i = 0; $i<count($price); $i++) {
                $qty_min = [
                    'name'     => 'price['.$i.'][qty_min]',
                    'contents' => $price[$i]['qty_min']
                ];
                array_push($multipart, $qty_min);

                $qty_max = [
                    'name'     => 'price['.$i.'][qty_max]',
                    'contents' => $price[$i]['qty_max']
                ];
                array_push($multipart, $qty_max);

                $price_p = [
                    'name'     => 'price['.$i.'][price]',
                    'contents' => $price[$i]['price']
                ];
                array_push($multipart, $price_p);
            }

            $product = $client->post($this->base_url.'add_product', [
                'multipart' => $multipart
            ]);
            $product_info = json_decode($product->getBody());
            
            //return redirect('index');
            //var_dump($product_info);
            
        }

        catch (Exception $e)
        {
            //var_dump($e->getMessage());
            $status = $false;
            $message = $e->getMessage();
        }

        return Redirect::back()->with('status', $product_info->status)->with('message', $product_info->message);
    }

    public function test(Request $request) {
        // $size = $request->size;
        // $price = $request->price_range;
        // $size[1] = (int)$size[1];
        $size = $request->size;
        // var_dump($size);
        $arr = array();

        foreach ($size as $key => $value) {
            //echo $value . " in " . $key . ", ";
            $obj = new stdClass();
            $obj->size_id = $key;
            $obj->qty = $value;
            array_push($arr, $obj);
        }

        var_dump($arr);
    }
}
