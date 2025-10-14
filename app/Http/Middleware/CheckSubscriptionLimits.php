<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionLimits
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $limitType): Response
    {
        $user = $request->user();
        
        if (!$user || !$user->business) {
            return redirect()->route('dashboard')
                ->with('error', 'Business information not found.');
        }

        $business = $user->business;
        $subscription = $business->activeSubscription;

        // Check if business has an active subscription
        if (!$subscription || !$subscription->subscriptionPlan) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You need an active subscription to perform this action.');
        }

        // Check specific limit type
        if ($limitType === 'users') {
            if (!$this->canAddUser($business, $subscription)) {
                return redirect()->back()
                    ->with('error', "You have reached the maximum number of users ({$subscription->subscriptionPlan->max_users}) for your current plan. Please upgrade to add more users.");
            }
        }

        if ($limitType === 'products') {
            if (!$this->canAddProduct($business, $subscription)) {
                return redirect()->back()
                    ->with('error', "You have reached the maximum number of products ({$subscription->subscriptionPlan->max_products}) for your current plan. Please upgrade to add more products.");
            }
        }

        return $next($request);
    }

    /**
     * Check if business can add more users.
     */
    private function canAddUser($business, $subscription): bool
    {
        $plan = $subscription->subscriptionPlan;
        
        // If no limit set, allow unlimited
        if ($plan->max_users === null) {
            return true;
        }

        $currentUserCount = $business->users()->count();
        return $currentUserCount < $plan->max_users;
    }

    /**
     * Check if business can add more products.
     */
    private function canAddProduct($business, $subscription): bool
    {
        $plan = $subscription->subscriptionPlan;
        
        // If no limit set, allow unlimited
        if ($plan->max_products === null) {
            return true;
        }

        $currentProductCount = $business->products()->count();
        return $currentProductCount < $plan->max_products;
    }
}

