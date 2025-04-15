<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'AdminMiddlewareLogin' => \App\Http\Middleware\Admin\AdminMiddlewareLogin::class,
            'AdminMiddlewareLogout'=>\App\Http\Middleware\Admin\AdminMiddlewareLogout::class,
            'CatalogMiddlewareLogin' => \App\Http\Middleware\Catalog\CatalogMiddlewareLogin::class,
            'CatalogMiddlewareLogout'=>\App\Http\Middleware\Catalog\CatalogMiddlewareLogout::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
