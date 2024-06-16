<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ziga.admin.auth' => \App\Http\Middleware\ZigaAuthenticate::class,
            //'ziga.admin' => \App\Http\Middleware\CheckIfIsAdmin::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'paystack.verify' => \App\Http\Middleware\VerifyPaystackSignature::class,
            'terminal.verify' => \App\Http\Middleware\VerifyTerminalSignature::class,
            'kyc' => \App\Http\Middleware\Kyc::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
