<?php

namespace App\Service\User_Service;
//
//use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use \Firebase\JWT\JWT;

class Test
{
    public function test()
    {
        $p = "Adrian Hartanto";
        $key = "secret";
        $expire  = time() + 60;
        $data = array(
            'exp'  => $expire,           // Expire
            'data' => [                  // Data related to the signer user
                'userId'   => $p, // userid from the users table
            ]
        );
        $jwt = JWT::encode($data, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));
//        return $decoded->data->userId;
        return $jwt;
    }
    
    
}
