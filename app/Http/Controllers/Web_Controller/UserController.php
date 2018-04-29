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
use Exception;

class UserController extends Controller
{
    public function login_page() {
        return view('login');
    }

    public function register(Request $request)
    {
        $full_name = $request->input('full_name');
        $gender = $request->input('gender');
        $phone_number = $request->input('phone_number');
        $email = $request->input('register_email');
        $password = $request->input('register_password');

        $client = new Client();
        try {
            $res = $client->post('http://localhost/dress_marketplace/api/register', [
                'form_params' => [
                    'full_name' => $full_name,
                    'gender' => $gender,
                    'phone_number' => $phone_number,
                    'email' => $email,
                    'password' => $password
                ]
            ]);
        }

        catch (ServerException $e) {
            return Redirect::back()->with('status' , 'Error');
        }

        $body = json_decode($res->getBody());
        $register_status = $body->status;
        if ($body->status == false) {
            $message = $body->message;
            return Redirect::back()->with('register_status', $register_status)->with('register_message', $message)->withInput();           
        }
        else {
            $message = $body->message;
            return Redirect::back()->with('register_status', $register_status)->with('register_message', $message);
        }
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
        $status = $body->status;
        if ($body->status == false) {
            $message = $body->message;
            return Redirect::back()->with('status' , $message);
        }

        else {
           //$cookie = cookie('jwt', $body->jwt);
            $cookie = cookie()->forever('jwt', $body->jwt);
            // $response = new \Illuminate\Http\Response(view('pages.index', ['name' => 'AD', 'login' => 'Adrianzz']));
            // $response->withCookie($cookie);
            //return $response;
            return redirect('index')->withCookie($cookie);
        }          
    }

    public function logout() {
        $cookie = \Cookie::forget('jwt');
        return redirect('index')->withCookie($cookie);
    }
}
