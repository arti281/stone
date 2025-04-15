<?php

namespace App\Http\Middleware\Catalog;

use Closure;
use Illuminate\Contracts\Session\SESSION;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CatalogMiddlewareLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('isUser')) {
            return $next($request);
        }
        return redirect()->route('catalog.user-login');
    }

}
