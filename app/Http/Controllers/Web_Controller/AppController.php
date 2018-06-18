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

class AppController extends Controller
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
        }
        else {
            $login_status = false;
        }

        $result = new stdClass();
        $result->login_status = $login_status;
        $result->user_info = $user_info;
        $result->user_store_info = $user_store_info;
        $result->user_cart_info = $user_cart_info;

        return $result;
    }

    public function index(Request $request)
    {
        $client = new Client();
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);

        return view('pages.index', ['login_info' => $login_info]);
    }

    public function open_store_page(Request $request) 
    {
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);

        return view('pages.open_store', ['login_info' => $login_info, 'jwt' => $jwt]);
    }

    public function register_store(Request $request) {
        $client = new Client();
        $jwt = $request->cookie('jwt');
        $multipart = [
            [
                'name'     => 'token',
                'contents' => $jwt
            ],
            [
                'name'     => 'store_name',
                'contents' => $request->store_name
            ],
            [
                'name'     => 'business_type',
                'contents' => $request->business_type
            ],
            [
                'name'     => 'established_year',
                'contents' => $request->established_year
            ],
            [
                'name'     => 'province',
                'contents' => $request->province
            ],
            [
                'name'     => 'city',
                'contents' => $request->city
            ],
            [
                'name'     => 'contact_person_name',
                'contents' => $request->contact_person_name
            ],
            [
                'name'     => 'contact_person_job_title',
                'contents' => $request->contact_person_job_title
            ],
            [
                'name'     => 'contact_person_phone_number',
                'contents' => $request->contact_person_phone_number
            ],
            [
                'name'     => 'description',
                'contents' => $request->description
            ],
            // [
            //     'name'     => 'bank_name',
            //     'contents' => $request->bank_name
            // ],
            // [
            //     'name'     => 'bank_account_number',
            //     'contents' => $request->bank_account_number
            // ],
            // [
            //     'name'     => 'branch',
            //     'contents' => $request->branch
            // ],
            // [
            //     'name'     => 'name_in_bank_account',
            //     'contents' => $request->name_in_bank_account
            // ],
            // [
            //     'name'     => 'courier',
            //     'contents' => json_encode($request->courier)
            // ]
        ];

        $courier_list = $request->courier;
        for ($i = 0; $i<count($courier_list); $i++) {
            $array = [
                'name'     => 'courier['.$i.']',
                'contents' => $courier_list[$i]
            ];
            array_push($multipart, $array);
        }

        if (Input::file('ktp')) {
            $ktp_file = Input::file('ktp');
            $ktp_array = [
                'name'     => 'ktp',
                'contents' => fopen( $ktp_file->getRealPath(), 'r'),
                'filename' => 'ktp.'.$ktp_file->getClientOriginalExtension()
            ];
            array_push($multipart, $ktp_array);
        }

        if (Input::file('siup')) {
            $siup_file = Input::file('siup');
            $siup_array = [
                'name'     => 'siup',
                'contents' => fopen( $siup_file->getRealPath(), 'r'),
                'filename' => 'siup.'.$siup_file->getClientOriginalExtension()
            ];
            array_push($multipart, $siup_array);
        }

        if (Input::file('npwp')) {
            $npwp_file = Input::file('npwp');
            $npwp_array = [
                'name'     => 'npwp',
                'contents' => fopen( $npwp_file->getRealPath(), 'r'),
                'filename' => 'npwp.'.$npwp_file->getClientOriginalExtension()
            ];
            array_push($multipart, $npwp_array);
        }

        if (Input::file('skdp')) {
            $skdp_file = Input::file('skdp');
            $skdp_array = [
                'name'     => 'skdp',
                'contents' => fopen( $skdp_file->getRealPath(), 'r'),
                'filename' => 'skdp.'.$skdp_file->getClientOriginalExtension()
            ];
            array_push($multipart, $skdp_array);
        }

        if (Input::file('tdp')) {
            $tdp_file = Input::file('tdp');
            $tdp_array = [
                'name'     => 'tdp',
                'contents' => fopen( $tdp_file->getRealPath(), 'r'),
                'filename' => 'tdp.'.$tdp_file->getClientOriginalExtension()
            ];
            array_push($multipart, $tdp_array);
        }

        if (Input::file('photo')) {
            $photo_file = Input::file('photo');
            $photo_array = [
                'name'     => 'photo',
                'contents' => fopen( $photo_file->getRealPath(), 'r'),
                'filename' => 'photo.'.$photo_file->getClientOriginalExtension()
            ];
            array_push($multipart, $photo_array);
        }

        if (Input::file('banner')) {
            $banner_file = Input::file('banner');
            $banner_array = [
                'name'     => 'banner',
                'contents' => fopen( $banner_file->getRealPath(), 'r'),
                'filename' => 'banner.'.$banner_file->getClientOriginalExtension()
            ];
            array_push($multipart, $banner_array);
        }
           
        $store = $client->post($this->base_url.'register_store', [
            'multipart' => $multipart
        ]);
        $store_info = json_decode($store->getBody());
        
        return redirect('index');
        // var_dump($store_info);
    }

    public function product_detail(Request $request, $product_id)
    {
        $client = new Client();
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);

        $product_detail_api = $client->post($this->base_url.'get_product_detail', [
            'form_params' => [
                'product_id' => $product_id,
                'token' => $jwt
            ]
        ]);
        $product_detail = json_decode($product_detail_api->getBody());

        if ($product_detail->status)
            return view('pages.product_detail', ['login_info' => $login_info, 'product_detail' => $product_detail]);
        else 
            print_r($product_detail->message);
    }

    public function add_to_bag (Request $request)
    {
        $product_id= $request->product_id;
        $jwt = $request->cookie('jwt');

        $size = $request->size;
        
        $arr = array();

        foreach ($size as $key => $value) {
            $obj = new stdClass();
            $obj->size_id = $key;
            $obj->qty = $value;
            array_push($arr, $obj);
        }

        $client = new Client();
        try {
            $res = $client->post($this->base_url.'add_to_bag', [
                'form_params' => [
                    'token' => $jwt,
                    'product_id' => $product_id,
                    'product_size_qty' => $arr
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function view_shopping_bag (Request $request)
    {
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);

        $client = new Client();
        try {
            $user_cart = $client->post($this->base_url.'view_shopping_bag', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);
            $result = json_decode($user_cart->getBody());

            return view('view_shopping_bag', ['login_info' => $login_info, 'result' => $result]);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    public function delete_product_from_bag (Request $request)
    {
        $product_id= $request->product_id;
        $jwt = $request->cookie('jwt');

        $client = new Client();
        try {
            $res = $client->post($this->base_url.'delete_product_from_bag', [
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

    public function checkout_page(Request $request)
    {
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);

        $client = new Client();
        try {
            $res = $client->post($this->base_url.'get_province_list', [
                'form_params' => [
                ]
            ]);

            $body = json_decode($res->getBody());

            return view('pages.checkout', ['login_info' => $login_info, 'province' => $body->province]);
        }

        catch (Exception $e) {
            echo $e->getMessage();
        }   
    }

    public function get_checkout_courier_page(Request $request)
    {
        $jwt = $request->cookie('jwt');
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'get_checkout_info', [
                'form_params' => [
                    'token' => $jwt,
                    'destination_city' => $request->destination_city
                ]
            ]);

            $result = json_decode($res->getBody());

            return view('pages.checkout_courier', ['result' => $result]);
            //var_dump($result);
        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkout(Request $request)
    {
        $receiver_name = $request->receiver_name;
        $address = $request->address;
        $province = $request->province;
        $city = $request->city;
        $phone_number = $request->phone_number;
        $postal_code = $request->postal_code;
        $use_point = $request->use_point;

        if ($use_point == null)
        {
            $use_point = 0;
        }

        $store_id = $request->store_id;
        $courier_id = $request->courier_id;
        $courier_service = $request->courier_service;
        $fee = $request->fee;
        $note = $request->note;

        $arr = [];

        foreach ($store_id as $key => $value) {
            $obj = new stdClass();
            $obj->store_id = $value;
            array_push($arr, $obj);
        }

        for($i=0;$i<sizeof($arr);$i++)
        {
            foreach ($courier_id as $key => $value) {
                if ($key == $arr[$i]->store_id) {
                    $arr[$i]->courier_id = $value;
                }
            }

            foreach ($courier_service as $key => $value) {
                if ($key == $arr[$i]->store_id) {
                    $arr[$i]->courier_service = $value;
                }
            }

            foreach ($fee as $key => $value) {
                if ($key == $arr[$i]->store_id) {
                    $arr[$i]->fee = $value;
                }
            }

            if ($note) {
                foreach ($note as $key => $value) {
                    if ($key == $arr[$i]->store_id) {
                        $arr[$i]->note = (string)$value;
                    }
                }
            }
        }

        //print_r($arr);

        $jwt = $request->cookie('jwt');
        $login_info = $this->get_login_info($jwt);
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'checkout', [
                'form_params' => [
                    'token' => $jwt,
                    'receiver_name' => $receiver_name,
                    'address' => $address,
                    'province' => $province,
                    'city' => $city,
                    'phone_number' => $phone_number,
                    'postal_code' => $postal_code,
                    'use_point' => $use_point,
                    'courier' => $arr
                ]
            ]);

            $body = json_decode($res->getBody());
            
            //print_r($body);

            if ($body->status) {
                //return redirect()->action('Web_Controller\AppController@checkout_success', ['data' => $body->data]);
                //return view('pages.checkout_successful', ['login_info' => $login_info, 'data' => $body->data]);
                return redirect('checkout_success')->with(['data' => $body->data]);
            }
            else {
                echo $body->message;
            }
        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkout_success(Request $request)
    {
        $jwt = $request->cookie('jwt');
        $login_info = $this->get_login_info($jwt);

        $data = Session::get('data');

        if ($data) {
            return view('pages.checkout_successful', ['login_info' => $login_info, 'data' => $data]);
        }
        else {
            echo "error";
        }
    }

    public function get_purchase_page (Request $request)
    {
        $jwt = $request->cookie('jwt');
        $login_info = $this->get_login_info($jwt);
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'get_purchase_payment', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $purchase_payment = json_decode($res->getBody())->result;
            $bank = json_decode($res->getBody())->bank;

            $res = $client->post($this->base_url.'get_order_status', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $order = json_decode($res->getBody())->result;

            $res = $client->post($this->base_url.'get_receipt_confirmation', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $shipping = json_decode($res->getBody())->result;

            return view('pages.purchase', 
                [
                    'login_info' => $login_info, 
                    'purchase_payment' => $purchase_payment,
                    'bank' => $bank,
                    'order' => $order,
                    'shipping' => $shipping,
                ]
            );
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function confirm_payment (Request $request)
    {
        $transaction_id = $request->transaction_id;
        $company_bank_id = $request->company_bank_id;
        $amount = $request->amount;
        $sender_bank = $request->sender_bank;
        $sender_account_number = $request->sender_account_number;
        $sender_name = $request->sender_name;
        $note = $request->note;
        $jwt = $request->cookie('jwt');

        $client = new Client();
        try {
            $res = $client->post($this->base_url.'confirm_payment', [
                'form_params' => [
                    'token' => $jwt,
                    'transaction_id' => $transaction_id,
                    'company_bank_id' => $company_bank_id,
                    'amount' => $amount,
                    'sender_bank' => $sender_bank,
                    'sender_account_number' => $sender_account_number,
                    'sender_name' => $sender_name,
                    'note' => $note,
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);
        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function confirm_receipt (Request $request)
    {
        $transaction_id = $request->transaction_id;
        $store_id = $request->store_id;

        $jwt = $request->cookie('jwt');

        $client = new Client();
        try {
            $res = $client->post($this->base_url.'confirm_receipt', [
                'form_params' => [
                    'token' => $jwt,
                    'transaction_id' => $transaction_id,
                    'store_id' => $store_id
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);
        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}