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

class UserController extends Controller
{
    public function login_page() {
        return view('login');
    }
    
    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        
        $client = new Client();
        try {
            $res = $client->post('http://localhost/dress_marketplace/api/login', [
                'form_params' => [
                    'email' => $email,
                    'password' => $password,
                ]
            ]);
        }
        catch (ServerException $e) {
            return Redirect::back()->with('status' , 'Error');
        }

        $body = json_decode($res->getBody());
        if ($body->status == false and $body->message == 'User Not Found') {
            return Redirect::back()->with('status' , $body->message);
        }

        else if ($body->status == false and $body->message == 'Invalid Credentials') {
            return Redirect::back()->with('status' , $body->message);
        }           
    }
}
