<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

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
        $user = new User();

        if($user->is_authorized($request))
        {
            $token_header = $request->header('Authorization');
            $token = new Token();
            $data = $token->decode($token_header);
            $request->request->add(['data_token' => $data]);

            return $next($request);
        }
        
        var_dump('no tienes permisos'); exit;
    }
}
