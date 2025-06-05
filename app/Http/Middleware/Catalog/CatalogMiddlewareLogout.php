<?php

namespace App\Http\Middleware\Catalog;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CatalogMiddlewareLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('isUser')) {
            return redirect()->route('catalog.front-user-account');
        }
        return $next($request);
    }
}
