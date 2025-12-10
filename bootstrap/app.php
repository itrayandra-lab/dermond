<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'customer.auth' => \App\Http\Middleware\CustomerAuth::class,
            'chatbot.access' => \App\Http\Middleware\ChatbotAccessMiddleware::class,
        ]);

        // Exclude payment webhook routes from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'payment/*',
        ]);

        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo('/dashboard');
    })
    ->withCommands([
        \App\Console\Commands\MigrateJsonData::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
