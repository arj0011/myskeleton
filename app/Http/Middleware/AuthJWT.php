<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Token;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\AuthorizationException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class AuthJWT
{
    /**
    * Handle an incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @param \Closure $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        try {

            JWTAuth::parseToken();

        }catch (JWTException $e){
            return response()->json(['status' => false , 'message' => 'Token Absent'],401);
        }
    
        try {

            $user=JWTAuth::toUser(trim($request->input('token')));
            
        } catch (Exception $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status'=>false,'message'=>'Invalid token.']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status'=>false,'message'=>'Expired token.']);
            } else {
                return response()->json(['status'=>false,'message'=>'Authentication error.']);
            }
        }


        // try{
        //     $token =  auth()->guard()->getToken();
        //     auth()->guard($this->guard)->authenticate($token);
        // } catch (Exception $e) {  
        //     if ($e instanceof TokenInvalidException){
        //         return response()->json(['status' => false , 'message' => 'Token Invalid'],401);
        //     } elseif($e instanceof TokenExpiredException) {            
        //         return response()->json(['status' => false , 'message' => 'Token Expired'],401);
        //     }else if ($e instanceof AuthenticationException) {
        //         return response()->json(['status' => false , 'message' => 'Token Unauthenticated'],401);
        //     } else if ($e instanceof TokenBlacklistedException){       
        //         return response()->json(['status' => false , 'message' => 'Token BlacklistedException'],401);
        //     }else{     
        //         return response()->json(['status' => false , 'message' =>  $e->getMessage()],401);
        //     }
        // }
        return $next($request);
    }
}
