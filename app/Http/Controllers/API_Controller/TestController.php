<?php

namespace App\Http\Controllers\API_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Test_Service\Test;

class TestController extends Controller
{
    public function test()
    {
        $test = new Test();
        return response()->json([
            'name' => $test->test(),
        ]);
    }
}
