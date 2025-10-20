<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Cookie;


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

                    // Assign 'admin' role
                    $adminRole = Role::where('name', 'admin')->first();
                    if ($adminRole) {
                        $user->assignRole($adminRole);
                    } else {
                        // Handle case where admin role doesn't exist
                        // Log an error or create the role if necessary
                        \Log::error('An Error occured, please try again or contact Admin.');
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


public function handleOneTap(Request $request)
    {
        $id_token = $request->input('credential');

        if (empty($id_token)) {
            Log::error('Google One Tap: No credential received.');
            return response()->json(['error' => 'No credential provided.'], 400);
        }

        // 1. Verify the ID Token
        $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);
        try {
            $payload = $client->verifyIdToken($id_token);
        } catch (\Exception $e) {
            Log::error('Google One Tap: Invalid ID Token: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid ID Token.'], 401);
        }

        if (!$payload || !isset($payload['email'])) {
            Log::error('Google One Tap: Token payload is invalid or missing email.');
            return response()->json(['error' => 'Authentication failed.'], 401);
        }

        // 2. Extract user data
        $email = $payload['email'];
        $name = $payload['name'] ?? null;
        $picture = $payload['picture'] ?? null;
        $google_id = $payload['sub'];

        // 3. Find or Create the user (Reusing your existing logic structure)
        $user = User::where('email', $email)->first();
        $showWelcome = false;

        if ($user) {
            // User exists, log them in
            Auth::login($user);
        } else {
            // User does not exist, create new user and business
            $business = null;
            DB::transaction(function () use ($email, $name, $picture, $google_id, &$user, &$business) {
                // NOTE: Using the payload data directly, instead of $googleUser from Socialite
                $businessName = $name ? $name . "'s Business" : 'New Business';

                $business = Business::create([
                    'name' => $businessName,
                    'short_name' => null,
                    'currency' => 'USD',
                    // ... other business fields ...
                ]);

                $user = User::create([
                    'name' => $name ?? 'Admin',
                    'email' => $email,
                    'profile_photo_path' => $picture,
                    'password' => \Hash::make(\Str::random(24)),
                    'status' => 'active',
                    'business_id' => $business->id,
                    'signup_method' => 'google-one-tap', // Differentiate signup method
                ]);

                $user->forceFill(['email_verified_at' => now()])->save();

                $adminRole = Role::where('name', 'admin')->first();
                if ($adminRole) {
                    $user->assignRole($adminRole);
                } else {
                    Log::error('An Error Occured, Please Retry.');
                }
                
                // Create subscription and default customer
                $business->subscriptions()->create(['trial_ends_at' => now()->addMonth(), 'is_active' => true]);
                Customer::create(['business_id' => $business->id, 'name' => 'Walk-in Customer', 'created_by' => $user->id]);

                // Dispatch welcome email
                SendWelcomeEmailJob::dispatch($user, $business);
            });
            
            Auth::login($user);
            $showWelcome = true;
        }

        // 4. Set cookie to suppress the One Tap prompt for a short period (recommended)
        Cookie::queue('g_skip_prompt', 'yes', 10); // 10 minutes

        // 5. Return success response with redirect URL (One Tap requires a JSON response)
        $redirectUrl = route('dashboard', absolute: false);
        $successMessage = $showWelcome 
            ? "Login Successful. Welcome to your new account!"
            : "Login Successful. Welcome back {$user->name}!";

        // You'll need to handle these session flashes via JavaScript on the client side
        return response()->json([
            'success' => true,
            'redirect' => $redirectUrl,
            'message' => $successMessage,
            'show_welcome' => $showWelcome
        ], 200);
    }



















}
