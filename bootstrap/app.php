<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Middleware\EnsureBusinessReady;
use App\Http\Middleware\EnsureOnboardingCompleted;
use App\Http\Middleware\CheckSubscriptionLimits;
use App\Http\Middleware\CheckActiveSubscription;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;



use Spatie\Permission\Exceptions\UnauthorizedException;







return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->web(append: [
            ProtectAgainstSpam::class,
            \App\Http\Middleware\BlockSuspendedUsers::class,
            //  EnsureBusinessReady::class,
            // CheckActiveSubscription::class,
            // CheckSubscriptionLimits::class,
        ]);

        $middleware->alias([
            'onboarding' => EnsureOnboardingCompleted::class,
            'check.subscription' => CheckActiveSubscription::class,
            'check.limits' => CheckSubscriptionLimits::class,

            // ... other aliases
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,

        ]);

    })



    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (UnauthorizedException $e, $request) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to perform this action. Please Contact Admin for authorization.');
        });
    })->create();
