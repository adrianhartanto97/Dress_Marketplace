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
        }
        else {
            $login_status = false;
        }

        $result = new stdClass();
        $result->login_status = $login_status;
        $result->user_info = $user_info;
        $result->user_store_info = $user_store_info;

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
                'product_id' => $product_id
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

}