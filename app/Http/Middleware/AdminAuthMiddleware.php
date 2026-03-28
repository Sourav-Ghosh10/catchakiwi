<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthMiddleware
{
    public function handle($request, Closure $next)
    {

        //echo session('admin_id');exit;
        if (session()->has('admin_login') && session('admin_login')===true) {
            return $next($request);
        }
        return redirect('admin/');
        //abort(403, 'Unauthorized action.');
    }
}