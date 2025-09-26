<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Business;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendWelcomeEmailJob;


class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create the user
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User exists, log them in
                Auth::login($user);
            } else {
                // User does not exist, create new user and business
                $business = null;
                DB::transaction(function () use ($googleUser, &$user, &$business) {
                    // Create business automatically

                    $businessName = $googleUser->getName() ? $googleUser->getName() . "'s Business" : 'New Business';

                    $business = Business::create([
                        'name' => $businessName,
                        'short_name' => null,
                        'currency' => 'USD',
                        'email' => null,
                        'phone' => null,
                        'country' => null,
                        'address' => null,
                        'timezone' => null,
                        'tin_no' => null,
                        'website' => null,
                        'logo_path' => null,
                    ]);

                    $user = User::create([
                        'name' => $googleUser->getName() ?? 'Admin',
                        'email' => $googleUser->getEmail(),
                        'profile_photo_path' => $googleUser->getAvatar(),
                        'password' => \Hash::make(\Str::random(24)), // Create a random password since we're using Google auth
                        'status' => 'active',
                        'business_id' => $business->id,
                        'signup_method' => 'google',

                    ]);

                    // force email verification
                    if (is_null($user->email_verified_at)) {
                        $user->forceFill(['email_verified_at' => now()])->save();
                    }

                    // Assign 'superadmin' role
                    $superadminRole = Role::where('name', 'superadmin')->first();
                    if ($superadminRole) {
                        $user->assignRole($superadminRole);
                    } else {
                        // Handle case where superadmin role doesn't exist
                        // Log an error or create the role if necessary
                        \Log::error('Superadmin role not found. Please create it.');
                    }

                    // Create 1-month free trial subscription
                    $business->subscriptions()->create([
                        'subscription_plan_id' => null,
                        'billing_cycle' => 'monthly',
                        'trial_ends_at' => now()->addMonth(),
                        'starts_at' => null,
                        'ends_at' => null,
                        'payment_method' => null,
                        'is_active' => true,
                        'auto_renew' => false,
                    ]);

                    Customer::create([
                        'business_id' => $business->id,
                        'name' => 'Walk-in Customer',
                        'email' => null,
                        'phone' => null,
                        'address' => null,
                        'tin_number' => null,
                        'status' => 'enabled',
                        'created_by' => $user->id,
                    ]);


                });

               
 // Dispatch the email job to the queue
            SendWelcomeEmailJob::dispatch($user, $business);


                Auth::login($user);

                
            }

            $name = auth()->user()->name;

            return redirect()->intended(route('dashboard', absolute: false))
                ->with('show_welcome', true)
                ->with('success', "Login Successful. Welcome back $name!");

        } catch (\Exception $e) {
            // Handle any errors that occur during the authentication process
            return redirect(route('login'))->withErrors(['google_error' => 'Unable to authenticate with Google. Please try again.']);
        }
    }
}
