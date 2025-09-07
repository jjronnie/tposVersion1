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
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
