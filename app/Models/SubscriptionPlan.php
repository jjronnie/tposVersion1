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


      // One plan can have many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscription_plan_id');
    }
}
