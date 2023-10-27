<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {

        if (in_array(Auth::user()->roles[0]->role_name,$roles)){
            return $next($request);
        }
        
        return redirect('/referrals')->with('error','Restricted Access. Contact admin');
        
    }
}
