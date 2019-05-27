<?php

namespace App\Http\Middleware;

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
            echo '没有用户id ，请先登录';echo '</br>';
            header('Refresh:1;url=/user/login');die;
        }
        return $next($request);
    }
}