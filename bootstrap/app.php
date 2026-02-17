<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'client' => \App\Http\Middleware\EnsureUserIsClient::class,
            'coach' => \App\Http\Middleware\EnsureUserIsCoach::class,
            'no-cache' => \App\Http\Middleware\PreventAuthenticatedPageCaching::class,
        ]);

        $middleware->redirectUsersTo(fn ($request) => $request->user()->isCoach()
            ? route('coach.index')
            : route('client.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
