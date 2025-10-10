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


          // 2. EXCLUSION: CRITICAL FIX & SAFEGUARD
        // Define all routes that must be accessible unconditionally to prevent lockouts.
        $excludedRoutes = [
            // Business Settings (to allow user to fix profile/subscription)
            $targetRoute,
            'business.update',
            
            // Standard Laravel Auth/Verification Routes (CRITICAL)
            'verification.notice',  // Route to the "Please verify email" page
            'verification.verify',  // Route handling the verification link
            'verification.send',    // Route to resend verification email
            'logout',               // Allow user to log out if needed
            'password.confirm',     // Allow user to confirm password for security features
        ];

        // Check if the current route is one of the exempted routes
        if ($request->routeIs($excludedRoutes)) {
            return $next($request);
        }

        // --- CHECK 1: Business Profile Completion ---
        if (!$business->isProfileComplete()) {
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
