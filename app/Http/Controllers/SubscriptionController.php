<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $business = Auth::user()->business;
        
        // Get current active subscription
        $currentSubscription = Subscription::with('subscriptionPlan')
            ->where('business_id', $business->id)
            ->where('is_active', true)
            ->first();
        
        // Get all available subscription plans
        $availablePlans = SubscriptionPlan::where('is_active', true)
            ->orderBy('monthly_cost', 'asc')
            ->get();
        
        // Get subscription history (last 10 records)
        $subscriptionHistory = Subscription::with('subscriptionPlan')
            ->where('business_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Check if on trial
        $onTrial = false;
        $trialEndsAt = null;
        if ($currentSubscription && $currentSubscription->trial_ends_at) {
            $trialEndsAt = \Carbon\Carbon::parse($currentSubscription->trial_ends_at);
            $onTrial = $trialEndsAt->isFuture();
        }
        
        return view('business.billing', compact(
            'currentSubscription',
            'availablePlans',
            'subscriptionHistory',
            'onTrial',
            'trialEndsAt'
        ));
    }
    
    public function upgrade(Request $request, SubscriptionPlan $plan)
    {
        $business = Auth::user()->business;
        
        $request->validate([
            'billing_cycle' => 'required|in:monthly,annual'
        ]);
        
        // Deactivate current subscription
        Subscription::where('business_id', $business->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        // Create new subscription
        $cost = $request->billing_cycle === 'annual' ? $plan->annual_cost : $plan->monthly_cost;
        $duration = $request->billing_cycle === 'annual' ? 365 : 30;
        
        $subscription = Subscription::create([
            'business_id' => $business->id,
            'subscription_plan_id' => $plan->id,
            'billing_cycle' => $request->billing_cycle,
            'starts_at' => now(),
            'ends_at' => now()->addDays($duration),
            'is_active' => true,
            'auto_renew' => true,
            'payment_method' => $request->payment_method ?? 'pending'
        ]);
        
        return redirect()->route('billing.index')
            ->with('success', 'Successfully upgraded to ' . $plan->name);
    }
    
    public function cancel(Subscription $subscription)
    {
        $business = Auth::user()->business;
        
        if ($subscription->business_id !== $business->id) {
            abort(403);
        }
        
        $subscription->update([
            'auto_renew' => false
        ]);
        
        return redirect()->route('billing.index')
            ->with('success', 'Subscription auto-renewal has been cancelled');
    }
}