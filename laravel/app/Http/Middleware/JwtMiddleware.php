<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        //
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            if(empty($user)){
                return response()->json(['status'=> false,'message'=>'Your account is deleted. Please contact to admin for further details.']);
            }elseif(empty($user->status)){
                return response()->json(['status'=> false,'is_deactivate'=>1,'message'=>'Your account is deactivated. Please contact to admin for further details.']);
            }
            //$user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => false, 'message' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => false, 'message' => 'Token is Expired']);
            }else{
                return response()->json(['status' => false, 'message' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}