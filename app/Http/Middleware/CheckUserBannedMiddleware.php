<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserBannedMiddleware
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
        if(auth()->check() && auth()->user()->is_banned){
            return redirect('banned')->with('error','User is banned. Contact admin');;
        }
        return $next($request);
    }
}
