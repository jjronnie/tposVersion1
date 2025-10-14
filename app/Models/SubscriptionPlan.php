<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
      use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'monthly_cost',
        'annual_cost',
        'max_users',
        'max_products',
        'is_active',
    ];

     protected $casts = [
        'monthly_cost' => 'decimal:2',
        'annual_cost' => 'decimal:2',
        'max_users' => 'integer',
        'max_products' => 'integer',
        'is_active' => 'boolean',
    ];


      // One plan can have many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscription_plan_id');
    }

     public function activeSubscriptions()
    {
        return $this->subscriptions()->where('is_active', true);
    }

     /**
     * Get all businesses subscribed to this plan.
     */
    public function businesses()
    {
        return $this->hasManyThrough(
            Business::class,
            Subscription::class,
            'subscription_plan_id',
            'id',
            'id',
            'business_id'
        )->where('subscriptions.is_active', true);
    }
}
