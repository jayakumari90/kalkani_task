<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AppSetting;


class VerifyAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   
    public function handle(Request $request, Closure $next)
    {
        $headers = apache_request_headers();
        $token = AppSetting::first();
        
        if(!isset($headers['auth_token']))
        {
            return response()->json(['status' => 'Auth Token not found']);
        }
        else
        {
            if($token->auth_token != $headers['auth_token'])
            {
                return response()->json(['status' => 'Auth token is Invalid']);
            }
            else{
                return $next($request);
            }
        }
    }
}
