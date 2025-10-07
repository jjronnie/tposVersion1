<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureBusinessReady
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if the user is authenticated and has a business attached
        if (!Auth::check() || !Auth::user()->business) {
            return $next($request);
        }

        $user = Auth::user();
        $business = $user->business;
        $targetRoute = 'business.settings';

        // 2. EXCLUSION: CRITICAL FIX
        // We must allow the user to access the settings view AND successfully submit the form
        // to update their details, otherwise the profile can never be completed.
        // If your update route is named differently, update the check below.
        if ($request->routeIs($targetRoute) || $request->routeIs('business.settings.update')) {
            return $next($request);
        }

        // --- CHECK 1: Business Profile Completion ---
        if (!$business->isProfileComplete()) {
            // Note: Use 'warning' or 'status' if 'error' is too aggressive/reserved for validation
            return redirect()->route($targetRoute)->with('error', 
                'Please complete your mandatory business settings (Name, Short Name, Currency, Country, and Timezone) to start using the system.'
            );
        }
        
        // --- CHECK 2: Subscription Status ---
        
        $hasActiveSubscription = $business->subscriptions()->where('is_active', true)->exists();
        $daysLeft = $business->trialDaysRemaining();

        // Condition for redirect: No active subscription AND Trial is expired (daysLeft is 0)
        if (!$hasActiveSubscription && ($daysLeft === 0)) {
            return redirect()->route($targetRoute)->with('error', 
                'Your trial has expired, and you do not have an active subscription. Please select a plan to continue.'
            );
        }

        return $next($request);
    }
}
