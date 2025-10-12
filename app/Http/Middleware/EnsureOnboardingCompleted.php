<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingCompleted
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Skip check for guest users
        if (!$user) {
            return $next($request);
        }

        $business = $user->business;

        // If no business exists, something is wrong
        if (!$business) {
            return redirect()->route('onboarding.index')
                ->with('error', 'Please complete business setup');
        }

        // If onboarding is not completed and user is not on onboarding route
        if (!$business->hasCompletedOnboarding() && !$request->routeIs('onboarding.*')) {
            return redirect()->route('onboarding.index')
                ->with('info', 'Please complete your business setup to continue');
        }

        // If onboarding is completed and user tries to access onboarding
        if ($business->hasCompletedOnboarding() && $request->routeIs('onboarding.index')) {
            return redirect()->route('dashboard')
                ->with('info', 'You have already completed onboarding');
        }

        return $next($request);
    }
}