<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'account_number',
        'short_name',
        'currency',
        'email',
        'phone_number',
        'address',
        'timezone',
        'tin_no',
        'website',
        'logo_path',
    ];


       // One business has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // One business has many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Optional: get active subscription easily
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('is_active', true);
    }

    // Business.php
public function onTrial(): bool
{
    $activeSubscription = $this->subscriptions()
        ->latest() // get latest subscription
        ->first();

    if (!$activeSubscription) return false;

    return $activeSubscription->trial_ends_at
        && now()->lessThanOrEqualTo($activeSubscription->trial_ends_at);
}


public function trialDaysRemaining(): ?int
{
    $activeSubscription = $this->subscriptions()->latest()->first();
    if (!$activeSubscription || !$activeSubscription->trial_ends_at) return null;

    return now()->diffInDays($activeSubscription->trial_ends_at, false);
}

}

