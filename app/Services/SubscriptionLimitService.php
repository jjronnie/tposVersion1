<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Subscription;

class SubscriptionLimitService
{
    /**
     * Check if business can add a user.
     */
    public function canAddUser(Business $business): array
    {
        $subscription = $business->activeSubscription;
        
        if (!$subscription || !$subscription->subscriptionPlan) {
            return [
                'allowed' => false,
                'message' => 'No active subscription found.',
                'current' => 0,
                'limit' => 0
            ];
        }

        $plan = $subscription->subscriptionPlan;
        $currentCount = $business->users()->count();
        
        if ($plan->max_users === null) {
            return [
                'allowed' => true,
                'message' => 'Unlimited users allowed.',
                'current' => $currentCount,
                'limit' => null
            ];
        }

        $allowed = $currentCount < $plan->max_users;
        
        return [
            'allowed' => $allowed,
            'message' => $allowed 
                ? "You can add more users ({$currentCount}/{$plan->max_users} used)."
                : "User limit reached ({$plan->max_users}/{$plan->max_users}). Upgrade your plan.",
            'current' => $currentCount,
            'limit' => $plan->max_users,
            'remaining' => max(0, $plan->max_users - $currentCount)
        ];
    }

    /**
     * Check if business can add a product.
     */
    public function canAddProduct(Business $business): array
    {
        $subscription = $business->activeSubscription;
        
        if (!$subscription || !$subscription->subscriptionPlan) {
            return [
                'allowed' => false,
                'message' => 'No active subscription found.',
                'current' => 0,
                'limit' => 0
            ];
        }

        $plan = $subscription->subscriptionPlan;
        $currentCount = $business->products()->count();
        
        if ($plan->max_products === null) {
            return [
                'allowed' => true,
                'message' => 'Unlimited products allowed.',
                'current' => $currentCount,
                'limit' => null
            ];
        }

        $allowed = $currentCount < $plan->max_products;
        
        return [
            'allowed' => $allowed,
            'message' => $allowed 
                ? "You can add more products ({$currentCount}/{$plan->max_products} used)."
                : "Product limit reached ({$plan->max_products}/{$plan->max_products}). Upgrade your plan.",
            'current' => $currentCount,
            'limit' => $plan->max_products,
            'remaining' => max(0, $plan->max_products - $currentCount)
        ];
    }

    /**
     * Get usage statistics for a business.
     */
    public function getUsageStats(Business $business): array
    {
        $subscription = $business->activeSubscription;
        
        if (!$subscription || !$subscription->subscriptionPlan) {
            return [
                'users' => ['current' => 0, 'limit' => 0, 'percentage' => 0],
                'products' => ['current' => 0, 'limit' => 0, 'percentage' => 0],
            ];
        }

        $plan = $subscription->subscriptionPlan;
        
        $userCount = $business->users()->count();
        $productCount = $business->products()->count();
        
        return [
            'users' => [
                'current' => $userCount,
                'limit' => $plan->max_users,
                'percentage' => $plan->max_users ? round(($userCount / $plan->max_users) * 100, 1) : 0,
                'remaining' => $plan->max_users ? max(0, $plan->max_users - $userCount) : null
            ],
            'products' => [
                'current' => $productCount,
                'limit' => $plan->max_products,
                'percentage' => $plan->max_products ? round(($productCount / $plan->max_products) * 100, 1) : 0,
                'remaining' => $plan->max_products ? max(0, $plan->max_products - $productCount) : null
            ],
        ];
    }

    /**
     * Check if approaching any limits (within 80%).
     */
    public function isApproachingLimits(Business $business): array
    {
        $stats = $this->getUsageStats($business);
        $warnings = [];

        if ($stats['users']['limit'] && $stats['users']['percentage'] >= 80) {
            $warnings[] = [
                'type' => 'users',
                'message' => "You're using {$stats['users']['percentage']}% of your user limit.",
                'current' => $stats['users']['current'],
                'limit' => $stats['users']['limit']
            ];
        }

        if ($stats['products']['limit'] && $stats['products']['percentage'] >= 80) {
            $warnings[] = [
                'type' => 'products',
                'message' => "You're using {$stats['products']['percentage']}% of your product limit.",
                'current' => $stats['products']['current'],
                'limit' => $stats['products']['limit']
            ];
        }

        return $warnings;
    }
}