<?php

namespace App\Http\Controllers\API_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Test_Service\Test;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $test = $request->test;
        foreach($test as &$t) {
            $t = "adrians";
        }
        return response()->json(['data'=>$test],200);
    }
}
