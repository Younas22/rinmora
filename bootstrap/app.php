<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin_catalog.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin_sales.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin_customers.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin_cms.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin_system.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware alias register karna
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();