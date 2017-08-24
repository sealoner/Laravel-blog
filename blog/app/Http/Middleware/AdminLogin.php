<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
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
        //判断session是否有登录信息，如果没有，就返回到登录页面
        if(!session('user')) {
            return redirect('blogadmin/login');
        }
        return $next($request);
    }
}
