<?php

namespace App\Http\Controllers\Web_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Test_Service\Test;
use Illuminate\Http\Response;

class TestController extends Controller
{
    public function test()
    {
        $test = new Test();
        $cookie = cookie('name', $test->test());
//        return view('pages.index', ['name' => 'AD', 'login' => 'Adrianzz'])->withCookie($cookie);
        $response = new \Illuminate\Http\Response(view('pages.index', ['name' => 'AD', 'login' => 'Adrianzz']));
        $response->withCookie($cookie);
        return $response;
    }
    
    public function test2(Request $request)
    {
        $value = $request->cookie('name');
        return view('pages.index', ['name' => $value, 'login' => 'Adrianzz']);
    }
}
