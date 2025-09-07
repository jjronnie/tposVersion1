@php
    $business = auth()->user()->business;
    $daysLeft = $business->trialDaysRemaining();
    $hasActiveSubscription = $business->subscriptions()->where('is_active', true)->exists();
@endphp

@if($daysLeft !== null && $daysLeft > 0)
    <!-- Trial active -->
    <section class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
        <div class="flex items-start md:items-center gap-3">
            <i data-lucide="crown" class="w-6 h-6 text-yellow-500"></i>

            <div>
                <h3 class="text-sm font-semibold text-gray-800">Trial Plan</h3>
                <p class="text-sm text-gray-600">
                    You are on trial version! Your trial ends in
                    <span class="font-medium text-gray-900">{{ $daysLeft }} {{ Str::plural('day', $daysLeft) }}</span>
                </p>
            </div>
        </div>

        <div>
            <a href="{{ route('business.settings') }}" class="btn">
                Change Plan
                <i data-lucide="chevrons-right" class="w-5 h-5 ml-2 text-white"></i>
            </a>
        </div>
    </section>

@elseif(!$hasActiveSubscription)
    <!-- Trial expired or no active subscription -->
    <section class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
        <div class="flex items-start md:items-center gap-3">
            <i data-lucide="alert-triangle" class="w-6 h-6 text-red-500"></i>

            <div>
                <h3 class="text-sm font-semibold text-gray-800">No Active Subscription</h3>
                <p class="text-sm text-gray-600">
                    Your trial has expired and you do not have an active subscription.
                    Please subscribe to continue using the system.
                </p>
            </div>
        </div>

        <div>
            <a href="{{ route('business.settings') }}" class="btn bg-red-500 text-white">
                Subscribe Now
                <i data-lucide="chevrons-right" class="w-5 h-5 ml-2"></i>
            </a>
        </div>
    </section>
@endif
