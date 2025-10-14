<x-app-layout>
    <x-page-title title="Subscription Management"/>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Current Plan Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Current Plan</h2>
        
        @if($currentSubscription)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $currentSubscription->subscriptionPlan->name ?? 'Trial Plan' }}
                            </h3>
                            <span class="px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded-full">
                                CURRENT
                            </span>
                            @if($onTrial)
                                <span class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-full">
                                    FREE TRIAL
                                </span>
                            @endif
                        </div>
                        
                        @if($currentSubscription->subscriptionPlan)
                            <p class="text-gray-600 mb-4">{{ $currentSubscription->subscriptionPlan->description }}</p>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Billing Cycle</p>
                                <p class="text-lg font-semibold text-gray-900 capitalize">
                                    {{ $currentSubscription->billing_cycle }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Current Cost</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    @if($currentSubscription->subscriptionPlan)
                                        ${{ number_format($currentSubscription->billing_cycle === 'annual' ? 
                                            $currentSubscription->subscriptionPlan->annual_cost : 
                                            $currentSubscription->subscriptionPlan->monthly_cost, 2) }}
                                        <span class="text-sm text-gray-500">/{{ $currentSubscription->billing_cycle === 'annual' ? 'year' : 'month' }}</span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    @if($onTrial)
                                        Trial Ends
                                    @else
                                        Renews On
                                    @endif
                                </p>
                                <p class="text-lg font-semibold text-gray-900">
                                    @if($onTrial)
                                        {{ $trialEndsAt->format('M d, Y') }}
                                        <span class="text-sm text-yellow-600">({{ $trialEndsAt->diffForHumans() }})</span>
                                    @elseif($currentSubscription->ends_at)
                                        {{ \Carbon\Carbon::parse($currentSubscription->ends_at)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        @if($currentSubscription->subscriptionPlan)
                            <div class="flex gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-semibold">Max Users:</span> 
                                    {{ $currentSubscription->subscriptionPlan->max_users ?? 'Unlimited' }}
                                </div>
                                <div>
                                    <span class="font-semibold">Max Products:</span> 
                                    {{ $currentSubscription->subscriptionPlan->max_products ?? 'Unlimited' }}
                                </div>
                                <div>
                                    <span class="font-semibold">Auto-Renew:</span> 
                                    {{ $currentSubscription->auto_renew ? 'Yes' : 'No' }}
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($currentSubscription->auto_renew)
                        <form action="{{ route('subscriptions.cancel', $currentSubscription) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel auto-renewal?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-danger">
                                Cancel Auto-Renew
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <p class="text-yellow-800 font-medium">You don't have an active subscription. Choose a plan below to get started!</p>
            </div>
        @endif
    </div>

    <!-- Available Plans Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Available Plans</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($availablePlans as $plan)
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition {{ 
                    $currentSubscription && $currentSubscription->subscription_plan_id === $plan->id ? 'ring-2 ring-blue-500' : '' }}">
                    
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $plan->description }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-3xl font-bold text-gray-900">${{ number_format($plan->monthly_cost, 2) }}</span>
                            <span class="text-gray-500">/month</span>
                        </div>
                        <div class="flex items-baseline gap-2 text-sm">
                            <span class="text-xl font-semibold text-gray-700">${{ number_format($plan->annual_cost, 2) }}</span>
                            <span class="text-gray-500">/year</span>
                            @if($plan->monthly_cost * 12 > $plan->annual_cost)
                                <span class="text-green-600 font-medium">
                                    (Save {{ number_format((($plan->monthly_cost * 12 - $plan->annual_cost) / ($plan->monthly_cost * 12)) * 100, 0) }}%)
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-6 space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">
                                <span class="font-semibold">{{ $plan->max_users ?? 'Unlimited' }}</span> Users
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">
                                <span class="font-semibold">{{ $plan->max_products ?? 'Unlimited' }}</span> Products
                            </span>
                        </div>
                    </div>
                    
                    @if($currentSubscription && $currentSubscription->subscription_plan_id === $plan->id)
                        <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-600 rounded-lg font-medium cursor-not-allowed">
                            Current Plan
                        </button>
                    @else
                        <button onclick="openUpgradeModal({{ $plan->id }}, '{{ $plan->name }}', {{ $plan->monthly_cost }}, {{ $plan->annual_cost }})" 
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                            {{ $currentSubscription ? 'Switch Plan' : 'Select Plan' }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Subscription History Section -->
    <div>
        <x-page-title title="Subscription History"/>
        
        @if($subscriptionHistory->isEmpty())
            <x-empty-state message="No Subscription Records."/>
        @else
            <x-table :headers="['#', 'Date', 'Plan', 'Billing Cycle', 'Period', 'Status', 'Payment Method', 'Auto-Renew']" >
                @foreach($subscriptionHistory as $index => $subscription)
                    <x-table.row>
                        <x-table.cell>{{ $index + 1 }}</x-table.cell>
                        <x-table.cell>{{ $subscription->created_at->format('M d, Y') }}</x-table.cell>
                        <x-table.cell>
                            <span class="font-medium">{{ $subscription->subscriptionPlan->name ?? 'N/A' }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="capitalize">{{ $subscription->billing_cycle }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            @if($subscription->starts_at && $subscription->ends_at)
                                {{ \Carbon\Carbon::parse($subscription->starts_at)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($subscription->ends_at)->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            @if($subscription->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inactive</span>
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            {{ $subscription->payment_method ?? 'N/A' }}
                        </x-table.cell>
                        <x-table.cell>
                            @if($subscription->auto_renew)
                                <span class="text-green-600 font-medium">Yes</span>
                            @else
                                <span class="text-gray-600">No</span>
                            @endif
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>
        @endif
    </div>

    <!-- Upgrade Modal -->
    <div id="upgradeModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Upgrade to <span id="modalPlanName"></span></h3>
            
            <form id="upgradeForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Billing Cycle</label>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="billing_cycle" value="monthly" class="text-blue-600 focus:ring-blue-500" required>
                                <div>
                                    <div class="font-medium text-gray-900">Monthly</div>
                                    <div class="text-sm text-gray-500">$<span id="monthlyCost"></span>/month</div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="billing_cycle" value="annual" class="text-blue-600 focus:ring-blue-500" required>
                                <div>
                                    <div class="font-medium text-gray-900">Annual</div>
                                    <div class="text-sm text-gray-500">$<span id="annualCost"></span>/year</div>
                                </div>
                            </div>
                            <span id="savingsBadge" class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full"></span>
                        </label>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeUpgradeModal()" 
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-medium hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                        Confirm Upgrade
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUpgradeModal(planId, planName, monthlyCost, annualCost) {
            document.getElementById('modalPlanName').textContent = planName;
            document.getElementById('monthlyCost').textContent = monthlyCost.toFixed(2);
            document.getElementById('annualCost').textContent = annualCost.toFixed(2);
            document.getElementById('upgradeForm').action = `/subscriptions/${planId}/upgrade`;
            
            const savings = ((monthlyCost * 12 - annualCost) / (monthlyCost * 12) * 100).toFixed(0);
            if (savings > 0) {
                document.getElementById('savingsBadge').textContent = `Save ${savings}%`;
                document.getElementById('savingsBadge').classList.remove('hidden');
            } else {
                document.getElementById('savingsBadge').classList.add('hidden');
            }
            
            document.getElementById('upgradeModal').classList.remove('hidden');
        }
        
        function closeUpgradeModal() {
            document.getElementById('upgradeModal').classList.add('hidden');
        }
        
        // Close modal on outside click
        document.getElementById('upgradeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUpgradeModal();
            }
        });
    </script>
</x-app-layout>