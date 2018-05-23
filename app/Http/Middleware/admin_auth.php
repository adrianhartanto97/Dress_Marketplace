<?php

namespace App\Http\Middleware;

use Closure;
use \Exception;
use \Firebase\JWT\JWT;

class admin_auth
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
        $jwt = $request->cookie('admin_jwt');
        try {
            $decoded = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            if ($decoded->data->admin_id == "admin") {
                return $next($request);
            }
            else {
                return redirect('admin_login_page');
            }
        }
        catch(Exception $error)
        {
            return redirect('admin_login_page');
        } 
    }
}
