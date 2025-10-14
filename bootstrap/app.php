<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Middleware\EnsureBusinessReady;
use App\Http\Middleware\EnsureOnboardingCompleted;
use App\Http\Middleware\CheckSubscriptionLimits;
use App\Http\Middleware\CheckActiveSubscription;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->web(append: [
            ProtectAgainstSpam::class,
                //  EnsureBusinessReady::class,
            // CheckActiveSubscription::class,
            // CheckSubscriptionLimits::class,
        ]);

        $middleware->alias([
            'onboarding' => EnsureOnboardingCompleted::class,
            'check.subscription' => CheckActiveSubscription::class,
            'check.limits' => CheckSubscriptionLimits::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
