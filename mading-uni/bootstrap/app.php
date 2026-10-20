<?php

use App\Http\Middleware\EnsureUniversityIsActive;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\EnsureUserRole;
use App\Http\Middleware\ShareUniversityTheme;
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
        // Alias middleware custom
        $middleware->alias([
            'role' => EnsureUserRole::class,
            'active' => EnsureUserIsActive::class,
            'university.active' => EnsureUniversityIsActive::class,
        ]);

        // Web middleware group tambahan
        $middleware->web(append: [
            ShareUniversityTheme::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();