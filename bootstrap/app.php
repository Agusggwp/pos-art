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
        // 1. Alias untuk custom middleware (seperti role kita)
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,  // Custom middleware-mu, tetap App namespace
        ]);

        // 2. Prioritas middleware (opsional, untuk urutan eksekusi)
        $middleware->priority([
            \Illuminate\Auth\Middleware\Authenticate::class,
            \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

        // 3. Group 'web' (middleware standar untuk web routes) - FIXED NAMESPACE!
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,  // <-- Fixed: Illuminate, bukan App
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,  // Fixed
            \Illuminate\Session\Middleware\StartSession::class,  // Fixed
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,  // Fixed
            \App\Http\Middleware\VerifyCsrfToken::class,  // Ini custom dari ui, tetap App
            \Illuminate\Routing\Middleware\SubstituteBindings::class,  // Fixed
        ]);

        // 4. Group 'api' (jika butuh API nanti, opsional)
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // 5. Middleware global (jalan di semua request, opsional)
        // $middleware->append(\Illuminate\Http\Middleware\TrustProxies::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom exception handling (opsional, misal log error)
        // $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
        //     if ($request->is('api/*')) { ... }
        // });
    })->create();