<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user || !$user->business) {
            return redirect()->route('dashboard')
                ->with('error', 'Business information not found.');
        }

        $business = $user->business;
        $subscription = $business->activeSubscription;

        // Check if business has an active subscription
        if (!$subscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You need an active subscription to access this feature.');
        }

        // Check if subscription is expired
        if ($subscription->isExpired()) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Your subscription has expired. Please renew to continue.');
        }

        // Check if trial has ended
        if ($subscription->trial_ends_at && $subscription->trial_ends_at->isPast() && !$subscription->starts_at) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Your trial period has ended. Please subscribe to continue.');
        }

        return $next($request);
    }
}
