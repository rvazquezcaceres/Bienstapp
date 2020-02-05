<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\helpers\Token;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $header_token = $request->header('Authorization');

        if(isset($header_token)){

            $token = new Token();
            $data_token = $token->decode($header_token);
            
            $user = User::where('email',$data_token->email)->first();
            if(isset($user)){
                $request->request->add(['data_token'=>$data_token]);
                return $next($request);
            }
        }               
        var_dump('no tienes permisos'); exit;
    
        //return $next($request);
    }
}
