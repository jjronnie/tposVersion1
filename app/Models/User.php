<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;



class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'business_id',
        'status',
        'email',
        'phone',
        'password',
        'profile_photo_path',
        'email_verified_at',
        'signup_method',
    ];

     public function scopeForBusiness($query, $businessId = null)
    {
        $businessId = $businessId ?? auth()->user()->business_id;
        return $query->where('business_id', $businessId);
    }

    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }




    // Each user belongs to one business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Check if user's business has completed onboarding
     */
    public function hasCompletedOnboarding(): bool
    {
        return $this->business && $this->business->hasCompletedOnboarding();
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    // app/Models/User.php



    // ... other imports ...

    public function getAllSessionsAttribute()
    {
        if (config('session.driver') !== 'database') {
            return [];
        }

        $sessions = DB::table(config('session.table', 'sessions'))
            ->where('user_id', $this->id)
            ->get();

        return $sessions->map(function ($session) {
            $payload = base64_decode($session->payload);
            $data = @unserialize($payload);

            // Return structured session data, you might need to adjust this depending on your Laravel version
            return [
                'ip_address' => $session->ip_address,
                'user_agent' => $session->user_agent,
                'last_active' => $session->last_activity,
                'agent' => $this->parseSessionUserAgent($session->user_agent)
            ];
        })->toArray();
    }

    protected function parseSessionUserAgent($userAgent)
    {
        // A simple method to parse user agent string for demonstration
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        return [
            'platform' => $agent->platform(),
            'browser' => $agent->browser()
        ];
    }
}
