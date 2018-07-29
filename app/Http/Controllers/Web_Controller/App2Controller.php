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
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

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
 
             return view('pages.wishlist',
                [
                    'active_nav' => "wishlist",
                    'login_info' => $login_info, 
                    'result' => $result
                ]
            );
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
     }

    

     public function withdraw (Request $request){
        $jwt = $request->cookie('jwt');
        $login_info = $this->get_login_info($jwt);
        $year= $request->year;
        $month = $request->month;

        $dt = Carbon::today();
        if($year=="") $year = $dt->year;
        if($month=="") {
            if($month<10){
                $month="0".$dt->month;
            }
            else{
                $month=$dt->month;
            }
         }
        $client = new Client();
        try {
            $req = $client->post($this->base_url.'financial_history', [
                'form_params' => [
                    'token' => $jwt,
                    'year' => $year,
                    'month' => $month
                ]
            ]);
            $res = json_decode($req->getBody())->result;

            return view('pages.balance_detail',
               [
                'active_nav' => "balance_detail",
                 'login_info' => $login_info,
                 'financial_history' => $res
               ]
           );
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }  

     }

    public function balance_withdraw (Request $request){
        $jwt = $request->cookie('jwt');
        $amount= $request->input('amount');
        $bank_name = $request->input('bank_name');
        $branch = $request->input('branch');
        $account_number = $request->input('account_number');
        $name_in_account = $request->input('name_in_account');
        $password =  $request->input('password');

        $client = new Client();
        try {
            $res = $client->post($this->base_url.'withdraw', [
                'form_params' => [
                    'token' => $jwt,
                    'amount' => $amount,
                    'bank_name' => $bank_name,
                    'branch' => $branch,
                    'account_number' => $account_number,
                    'name_in_account' => $name_in_account,
                    'password' => $password

                ]
            ]);
            
        }
        
        catch (ServerException $e) {
            return Redirect::back()->with('status' , 'Error');
        }
        $body = json_decode($res->getBody());

        $withdraw_status = $body->status;
        if ($body->status == false) {
            $message = $body->message;
            return Redirect::back()->with('withdraw_status', $withdraw_status)->with('withdraw_message', $message)->withInput();           
        }
        else {
            $message = $body->message;
            return Redirect::back()->with('withdraw_status', $withdraw_status)->with('withdraw_message', $message);
        }

     } 

     public function add_to_favorite(Request $request){
        $store_id= $request->store_id;
        $jwt = $request->cookie('jwt');

    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'add_to_favorite', [
                'form_params' => [
                    'token' => $jwt,
                    'store_id' => $store_id,
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
     }

     
 
     public function delete_from_favorite (Request $request)
     {
         $store_id= $request->store_id;
         $jwt = $request->cookie('jwt');
 
         $client = new Client();
         try {
             $res = $client->post($this->base_url.'delete_from_favorite', [
                 'form_params' => [
                     'token' => $jwt,
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

      public function favorite_store (Request $request)
     {
         $jwt = $request->cookie('jwt');
 
         $login_info = $this->get_login_info($jwt);
 
         $client = new Client();
         try {
             $user_wishlist = $client->post($this->base_url.'my_favorite', [
                 'form_params' => [
                     'token' => $jwt
                 ]
             ]);
             $result = json_decode($user_wishlist->getBody());
 
             return view('pages.favorite_store',
                [
                  'active_nav' => "favorite_store",
                  'login_info' => $login_info, 
                  'result' => $result
                ]
            );
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
     }

      

     public function search (Request $request)
     {
        
         try {
             $jwt = $request->cookie('jwt');
 
             $login_info = $this->get_login_info($jwt);
     
             $product_name = $request->product_name;
             $client = new Client();
             $search = $client->post($this->base_url.'search', [
                 'form_params' => [
                     'product_name' => $product_name
                 ]
             ]);
             $result = json_decode($search->getBody());
             $collection = collect($result->product_info);

              $page = Input::get('page', 1);
            $perPage = 16;

             $search_result = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url('search')]);
 
             return view('pages.search',
                [
                  'login_info' => $login_info,    
                  'search_result' => $result,
                  'search' => $search_result,
                  'has_search' => "true"


                ]
            )->render();
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
          
     }

     

   public function filter (Request $request)
     {
         $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);
        $min_order =$request->min_order;
        $price_min=$request->price_min;
        $price_max=$request->price_max;
        $rating_min=$request->rating_min;
        $rating_max=$request->rating_max;
        $province=$request->province;
        $city=$request->city;
        $courier_id=$request->courier_id;
         $client = new Client();
         try {
             $search = $client->post($this->base_url.'advance_search', [
                 'form_params' => [
                     'min_order' => $min_order,
                     'price_min'=>$price_min,
                     'price_max'=>$price_max,
                     'rating_min' => $rating_min,
                     'rating_max' => $rating_max,
                     'province'=> $province,
                     'city' => $city,
                     'courier_id' => $courier_id

                 ]
             ]);

             $result = json_decode($search->getBody());
             $collection = collect($result->product_info);

             $page = Input::get('page', 1);
             $perPage = 16;

             $search_result = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url('advance_search')]);
 
             
            return view('pages.search',
                [
                  'login_info' => $login_info,    
                  'filter_result' => $result,
                   'filter' => $search_result,

                  'has_search' => "false"
                ]
            )->render();

             
             
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
          
     }

     public function get_search_item (Request $request)
     {
         $jwt = $request->cookie('jwt');
 
         $login_info = $this->get_login_info($jwt);
 
         $product_name = $request->product_name;
         $client = new Client();
         try {
             $search = $client->post($this->base_url.'search', [
                 'form_params' => [
                     'product_name' => $product_name
                 ]
             ]);
             $result = json_decode($search->getBody());
 
             return view('pages.search',
                [
                  'login_info' => $login_info,    
                  'result' => $result,
                  
                ]
            );
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
          
     }

 

    public function store_detail(Request $request, $store_id)
    {
        set_time_limit(86400);
        $client = new Client();
        $jwt = $request->cookie('jwt');

        $login_info = $this->get_login_info($jwt);

        $store_detail_api = $client->post($this->base_url.'get_user_store_detail', [
            'form_params' => [
                'store_id' => $store_id,
                'token' => $jwt
            ]
        ]);
        $store_detail = json_decode($store_detail_api->getBody());

        if ($store_detail->status)
            return view('pages.store_detail', ['login_info' => $login_info, 'store_detail' => $store_detail,'store_detail_api'=>$store_detail_api]);
        else 
            print_r($store_detail->message);
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


     public function request_for_quotation (Request $request) {
        $jwt = $request->cookie('jwt');
        $dress_attributes = null;
        try {
            $client = new Client();
            $res = $client->post($this->base_url.'view_active_rfq_request', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $active_rfq = json_decode($res->getBody())->result;

            $res = $client->post($this->base_url.'rfq_request_history', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $rfq_history = json_decode($res->getBody())->result;
        }
        catch(Exception $e) {

        }
        $login_info = $this->get_login_info($jwt);


        return view('pages.request_for_quotation', ['login_info' => $login_info, 'active_nav' => 'rfq', 'active_rfq' => $active_rfq, 'rfq_history' => $rfq_history]);
            
      
    }

    public function add_rfq (Request $request)
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
                    'name'     => 'item_name',
                    'contents' => $request->item_name
                ],
                [
                    'name'     => 'description',
                    'contents' => $request->description
                ],
                [
                    'name'     => 'qty',
                    'contents' => $request->qty
                ],
                [
                    'name'     => 'request_expired',
                    'contents' => $request->request_expired
                ],
                [
                    'name'     => 'budget_unit_min',
                    'contents' => $request->budget_unit_min
                ],
                [
                    'name'     => 'budget_unit_max',
                    'contents' => $request->budget_unit_max
                ],
                [
                    'name'     => 'photo',
                    'contents' => fopen( $photo_file->getRealPath(), 'r'),
                    'filename' => 'photo.'.$photo_file->getClientOriginalExtension()
                ],
                
               
            ];
           
            $product = $client->post($this->base_url.'add_rfq_request', [
                'multipart' => $multipart
            ]);
            $product_info = json_decode($product->getBody());
            
          

            $status = $product_info->status;
            $message = $product_info->message;
            
        }

        catch (Exception $e)
        {
            //var_dump($e->getMessage());
            $status = false;
            $message = $e->getMessage();
        }

        return Redirect::back()->with('status', $status)->with('message', $message);
    }

     public function seller_panel_request_for_quotation (Request $request) {
        $jwt = $request->cookie('jwt');
        $store = $this->check_user_store($jwt);

        try {
            $client = new Client();
            $res = $client->post($this->base_url.'rfq_offer_history', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $rfq_offer_history = json_decode($res->getBody())->result;
        }
        catch(Exception $e) {

        }

        if ($store) {
            $login_info = $this->get_login_info($jwt);
            return view('pages.seller_panel_request_for_quotation', ['login_info' => $login_info,'store_info' => $store, 'active_nav' => 'rfq' , 'rfq_offer_history' => $rfq_offer_history]);
            
        }
        else {
            return redirect('index');
        }
    }

    public function get_rfq_request_list (Request $request)
    {
        $jwt = $request->cookie('jwt');
        $store = $this->check_user_store($jwt);
        try {
            $client = new Client();
            $res = $client->post($this->base_url.'seller_get_rfq_request', [
                'form_params' => [
                    'token' => $jwt
                ]
            ]);

            $rfq_res = json_decode($res->getBody())->result;
            $collection = collect($rfq_res);
            $page = Input::get('page', 1);
            $perPage = 5;

            $rfq = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url('rfq_request_list')]);
        }
        catch(Exception $e) {
            echo "a";
        }

        if ($store) {
            return view('pages.seller_panel_rfq_request_list', ['rfq' => $rfq])->render();
        }
        else {
            echo "b";
        }
    }

    public function add_rfq_offer (Request $request)
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
                    'name'     => 'rfq_request_id',
                    'contents' => $request->rfq_request_id
                ],
                [
                    'name'     => 'description',
                    'contents' => $request->description
                ],
                [
                    'name'     => 'price_unit',
                    'contents' => $request->price_unit
                ],
                [
                    'name'     => 'weight_unit',
                    'contents' => $request->weight_unit
                ],
                [
                    'name'     => 'photo',
                    'contents' => fopen( $photo_file->getRealPath(), 'r'),
                    'filename' => 'photo.'.$photo_file->getClientOriginalExtension()
                ],
                
               
            ];
           
            $rfq = $client->post($this->base_url.'add_rfq_offer', [
                'multipart' => $multipart
            ]);
            $rfq_info = json_decode($rfq->getBody());
            
          

            $status = $rfq_info->status;
            $message = $rfq_info->message;
            
        }

        catch (Exception $e)
        {
            //var_dump($e->getMessage());
            $status = false;
            $message = $e->getMessage();
        }

        return Redirect::back()->with('status', $status)->with('message', $message);
    }

    public function accept_rfq_offer (Request $request)
    {
        $rfq_offer_id= $request->rfq_offer_id;
        $jwt = $request->cookie('jwt');

    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'accept_rfq_offer', [
                'form_params' => [
                    'token' => $jwt,
                    'rfq_offer_id' => $rfq_offer_id,
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

     public function close_rfq_request (Request $request)
    {
        $rfq_request_id= $request->rfq_request_id;
        $jwt = $request->cookie('jwt');

    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'close_rfq_request', [
                'form_params' => [
                    'token' => $jwt,
                    'rfq_request_id' => $rfq_request_id,
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function financial_history(Request $request)
    {
        $jwt = $request->cookie('jwt');
        $year= $request->year;
        $month = $request->month;
    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'financial_history', [
                'form_params' => [
                    'token' => $jwt,
                    'year' => $year,
                    'month' => $month
                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('result', $body->result);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

     public function update_store_information(Request $request)
    {
        try {
             $client = new Client();
             $jwt = $request->cookie('jwt');


             $multipart = [
                [
                    'name'     => 'token',
                    'contents' => $jwt
                ],
                [
                    'name'     => 'store_id',
                    'contents' => $request->store_id
                ],
                [
                    'name'     => 'name',
                    'contents' => $request->name
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
           
            ];
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
           

            $store = $client->post($this->base_url.'update_store_information', [
                'multipart' => $multipart
            ]);
            $body = json_decode($store->getBody());
            return Redirect::back()->with('status', $body->status)->with('message', $body->message);
        }
         catch (Exception $e) {
              return Redirect::back()->with('status', false)->with('message', $e->getMessage());
        }
    }

     public function delete_user_store_courier (Request $request)
    {
        $jwt = $request->cookie('jwt');
        $store_id = $request->store_id;
        $courier_id = $request->courier_id;

    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'delete_user_store_courier', [
                'form_params' => [
                    'token' => $jwt,
                    'store_id' => $store_id,
                    'courier_id' => $courier_id

                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

     public function insert_user_store_courier (Request $request)
    {
        $jwt = $request->cookie('jwt');
        $store_id = $request->store_id;
        $courier_id = $request->courier_id;

    
        $client = new Client();
        try {
            $res = $client->post($this->base_url.'insert_user_store_courier', [
                'form_params' => [
                    'token' => $jwt,
                    'store_id' => $store_id,
                    'courier_id' => $courier_id

                ]
            ]);

            $body = json_decode($res->getBody());

            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

        }

        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

     public function settings (Request $request)
     {
         $jwt = $request->cookie('jwt');
 
         $login_info = $this->get_login_info($jwt);
         $phone_number=$request->phone_number;
         $full_name = $request->full_name;
 
         $client = new Client();
         try {
             $user = $client->post($this->base_url.'update_user_profile', [
                 'form_params' => [
                     'token' => $jwt,
                     'phone_number'=>$phone_number,
                     'full_name'=>$full_name

                 ]
             ]);
             $result = json_decode($user->getBody());
 
             return view('pages.settings',
                [
                    'active_nav' => "settings",
                    'login_info' => $login_info, 
                    'result' => $result
                ]
            );
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
     }

     public function psettings (Request $request)
     {
         $jwt = $request->cookie('jwt');
 
         $login_info = $this->get_login_info($jwt);
         $phone_number=$request->phone_number;
         $full_name = $request->full_name;
 
         $client = new Client();
         try {
             $user = $client->post($this->base_url.'update_user_profile', [
                 'form_params' => [
                     'token' => $jwt,
                     'phone_number'=>$phone_number,
                     'full_name'=>$full_name

                 ]
             ]);
             $body = json_decode($user->getBody());
 
            return Redirect::back()->with('status', $body->status)->with('message', $body->message);

           
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
     }

     public function get_settings (Request $request)
     {
         $jwt = $request->cookie('jwt');
 
         $login_info = $this->get_login_info($jwt);
       
 
         $client = new Client();
         try {
            
             return view('pages.settings',
                [
                    'active_nav' => "settings",
                    'login_info' => $login_info, 

                ]
            );
         }
         catch (Exception $e) {
             echo $e->getMessage();
         }  
     }


     public function post_settings(Request $request)
    {
        try {
             $client = new Client();
             $jwt = $request->cookie('jwt');
             $login_info = $this->get_login_info($jwt);
           
         $client = new Client();

             $multipart = [
                [
                    'name'     => 'token',
                    'contents' => $jwt
                ],
                [
                    'name'     => 'phone_number',
                    'contents' => $request->phone_number
                ],
               
                [
                    'name'     => 'full_name',
                    'contents' => $request->full_name
                ],
               
           
            ];
            // if (Input::file('avatar')) {
            //     $photo_file = Input::file('avatar');
            //     $photo_array = [
            //         'name'     => 'avatar',
            //         'contents' => fopen( $photo_file->getRealPath(), 'r'),
            //         'filename' => 'avatar.'.$photo_file->getClientOriginalExtension()
            //     ];
            //     array_push($multipart, $photo_array);
            // }
            
            // if (Input::file('avatar')) {
            //      $image = $client->post($this->base_url.'update_user_profile', [
            //             'multipart' => $multipart
            //      ]);
            // }
            
            $user = $client->post($this->base_url.'update_user_profile', [
                    'multipart' => $multipart
             ]);
            
           
            $body = json_decode($user->getBody());
            return Redirect::back()->with('status', $body->status)->with('message', $body->message);
        }
         catch (Exception $e) {
              return Redirect::back()->with('status', false)->with('message', "Server sedang sibuk");
        }
    }


}
