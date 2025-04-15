<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Contracts\Session\SESSION;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddlewareLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('admin_id')) {
            return $next($request);
        }
        return redirect()->route('admin-login');
    }

}
