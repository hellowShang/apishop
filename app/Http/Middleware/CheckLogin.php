<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;

use Closure;


class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty($_COOKIE['uid'])){
            header('Refresh:1;url=/user/login');
        }
        return $next($request);
    }
}