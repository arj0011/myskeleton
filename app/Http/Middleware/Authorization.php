<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authorization
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
        //If user has this //role
        if (Auth::user()->hasRole('superadmin')){

            //If user is creating a post
            // if ($request->is('store-role')){
            //     if (!Auth::user()->hasPermissionTo('store-role')){
            //         abort('401');
            //     } else {
            //         return $next($request);
            //     }
            // }
            
            return $next($request);
        }else{
            abort('401');
            return redirect('/')->with('failed','You are not authorized');
        } 
    }
}
