<?php

use App\Models\News;
use App\Models\Admin;
use App\Policies\NewsPolicy;
use Illuminate\Http\Request;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([

            'admin' => \App\Http\Middleware\AdminMiddleware::class,

            'auth' => \App\Http\Middleware\AuthenticateMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 401);
            }
        });
    })
    ->booted(function() {
        Gate::policy(News::class, NewsPolicy::class);
        Gate::policy(Admin::class, AdminPolicy::class);
    })
    ->create();

