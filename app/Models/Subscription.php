<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    protected $fillable = [
        'business_id', 'subscription_plan_id', 'billing_cycle', 
        'trial_ends_at', 'starts_at', 'ends_at', 
        'payment_method', 'is_active', 'auto_renew'
    ];

    protected $casts = [
        'trial_ends_at' => 'date',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_active' => 'boolean',
        'auto_renew' => 'boolean',
    ];

    // Each subscription belongs to one business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Each subscription optionally belongs to a plan
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

     /**
     * Check if subscription is currently on trial.
     */
    public function isOnTrial(): bool
    {
        if (!$this->trial_ends_at) {
            return false;
        }
        
        return now()->lessThan($this->trial_ends_at);
    }


    /**
     * Check if subscription has expired.
     */
    public function isExpired(): bool
    {
        if (!$this->ends_at) {
            return false;
        }
        
        return now()->greaterThan($this->ends_at);
    }


     /**
     * Check if subscription is currently valid.
     */
    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Get the cost based on billing cycle.
     */
    public function getCost(): float
    {
        if (!$this->subscriptionPlan) {
            return 0;
        }
        
        return $this->billing_cycle === 'annual' 
            ? $this->subscriptionPlan->annual_cost 
            : $this->subscriptionPlan->monthly_cost;
    }

    /**
     * Get days remaining in subscription.
     */
    public function daysRemaining(): int
    {
        if (!$this->ends_at) {
            return 0;
        }
        
        return now()->diffInDays($this->ends_at, false);
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('ends_at', '<', now());
    }

    /**
     * Scope a query to only include trial subscriptions.
     */
    public function scopeOnTrial($query)
    {
        return $query->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>', now());
    }


}
