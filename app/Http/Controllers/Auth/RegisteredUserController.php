<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

        ]);

        DB::transaction(function () use ($request, &$user, &$business) {

            // 1. Create business automatically

            $business = Business::create([
                'name' => $request->name,
                'short_name' => $request->name,
                'currency' => 'USD',

            ]);

            $user = User::create([
                'name' => "Admin",
                'email' => $request->email,
                'password' => Hash::make($request->password),
                  'status' => 'active',
                'business_id' => $business->id,
            ]);

             $user->assignRole('superadmin');



            // Create 1-month free trial subscription
            $business->subscriptions()->create([
                'subscription_plan_id' => null,          // no plan during trial
                'billing_cycle' => 'monthly',
                'trial_ends_at' => now()->addMonth(),    // trial ends in 1 month
                'starts_at' => null,                     // will be set when plan starts
                'ends_at' => null,                       // will be set when plan starts
                'payment_method' => null,
                'is_active' => true,
                'auto_renew' => false,
            ]);

             // 4. Create default Walk-in Customer
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

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
