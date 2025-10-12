<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Business extends Model
{
    use HasFactory, SoftDeletes;



    protected $fillable = [
        'name',
        'account_number',
        'short_name',
        'currency',
        'currency_symbol',
        'email',
        'phone',
        'country',
        'address',
        'timezone',
        'tin_no',
        'logo_path',
        'date_format',
        'source',
        'source_details',
        'onboarding_completed',
        'onboarding_completed_at',
    ];


      protected $casts = [
        'onboarding_completed' => 'boolean',
        'onboarding_completed_at' => 'datetime',
    ];


     /**
     * Check if business has completed onboarding
     */
    public function hasCompletedOnboarding(): bool
    {
        return $this->onboarding_completed === true;
    }

    /**
     * Mark onboarding as completed
     */
    public function completeOnboarding(): void
    {
        $this->update([
            'onboarding_completed' => true,
            'onboarding_completed_at' => now(),
        ]);
    }

    /**
     * Get currency symbols
     */
    public static function getCurrencySymbols(): array
    {
        return [
            'UGX' => 'UGX',
            'USD' => '$',
            'KES' => 'KSh',
            'TZS' => 'TSh',
            'EUR' => '€',
            'GBP' => '£',
        ];
    }


       // One business has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

       public function customers()
    {
        return $this->hasMany(Customer::class);
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
    $trialEndsAt = $this->trialEndsAt();

        if (!$trialEndsAt) {
            return null; // No trial period defined
        }

        $now = Carbon::now()->startOfDay();
        $trialEnd = $trialEndsAt->endOfDay();

        if ($now->greaterThan($trialEnd)) {
            return 0; // Trial has expired
        }

        return $now->diffInDays($trialEnd);
}


   public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


 /**
     * Finds the latest subscription trial end date.
     */
    public function trialEndsAt(): ?Carbon
    {
        $latestTrial = $this->subscriptions()
            ->whereNotNull('trial_ends_at')
            ->orderByDesc('trial_ends_at')
            ->first();

        // Ensure the returned value is a Carbon instance
        return $latestTrial ? Carbon::parse($latestTrial->trial_ends_at) : null;
    }

    /**
     * Calculates the remaining days in the trial period.
     * Returns null if no trial was ever set. Returns 0 if expired.
     */
 

    /**
     * Checks if the mandatory business profile fields are complete.
     */
    public function isProfileComplete(): bool
    {
        return $this->name !== null &&
               $this->short_name !== null &&
               $this->currency !== null &&
               $this->country !== null &&
               $this->timezone !== null;
    }

}

