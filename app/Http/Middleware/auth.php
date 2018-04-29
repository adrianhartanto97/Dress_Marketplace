<?php

namespace App\Http\Middleware;

use Closure;
use \Exception;
use \Firebase\JWT\JWT;

class auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $jwt_key = "YYKPRvHTWOJ2DJaEPkXWiuGbAQpPmQ9x";
    public function handle($request, Closure $next)
    {
        $jwt = $request->cookie('jwt');
        try {
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            return $next($request);
        }
        catch(Exception $error)
        {
            return redirect('index');
        }    
    }
}
