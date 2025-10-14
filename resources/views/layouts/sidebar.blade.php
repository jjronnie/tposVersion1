<div class="w-80 lg:w-64 bg-primary text-white flex flex-col fixed top-0 left-0 h-screen z-40 lg:z-[10000] transform transition-transform duration-300 -translate-x-full lg:translate-x-0"
    id="sidebar">
    <!-- Sidebar Header -->

    <div class="sidebar-header">
        <div class="flex items-center space-x-3">
            <div class="w-full h-12  rounded-lg flex items-center justify-center text-white font-bold text-lg">
                <span>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/tpos1.png') }}" alt="LOGO">
                    </a>
                </span>
            </div>

        </div>
        <button class="lg:hidden p-1 rounded-md hover:bg-blue-900 transition-colors" id="closeSidebar">

            <i data-lucide="x" class="w-4 h-4 text-white"></i>
        </button>
    </div>

    <!-- Scrollable Navigation Area -->



    <div class="flex-1 overflow-y-auto no-scrollbar">
        <nav class="p-4 space-y-1">
            {{-- Dashboard --}}

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-white"></i>
                <span>Dashboard</span>
            </a>
            <div class="space-y-1">

                <a href="{{ route('products.index') }}" 
                                class="sidebar-link {{ request()->routeIs('products.*') ? 'sidebar-link-active' : '' }}">

                    <i data-lucide="package" class="w-4 h-4 text-white"></i>
                    <span>Products</span>
                </a>

            

                 <a href="{{ route('sales.index') }}" 
                                class="sidebar-link {{ request()->routeIs('sales.*') ? 'sidebar-link-active' : '' }}">

                    <i data-lucide="shopping-cart" class="w-4 h-4 text-white"></i>
                    <span>Sales</span>
                </a>

              
                    {{-- Customers --}}
                <a href="{{ route('customers.index') }}"
                    class="sidebar-link {{ request()->routeIs('customers.*') ? 'sidebar-link-active' : '' }}">
                    <i data-lucide="users" class="w-4 h-4 text-white"></i>
                    <span>Customers</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i data-lucide="truck" class="w-4 h-4 text-white"></i>
                    <span>Purchases</span>
                </a>

                <a href="{{ route('suppliers.index') }}" class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'sidebar-link-active' : '' }}">
                    <i data-lucide="building-2" class="w-4 h-4 text-white"></i>
                    <span>Suppliers</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i data-lucide="wrench" class="w-4 h-4 text-white"></i>
                    <span>Tools</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-white"></i>
                    <span>Statistics</span>
                </a>


                {{-- Users --}}
                <a href="{{ route('users.index') }}"
                    class="sidebar-link {{ request()->routeIs('users.*') ? 'sidebar-link-active' : '' }}">
                    <i data-lucide="users" class="w-4 h-4 text-white"></i>
                    <span>Users</span>
                </a>


                {{-- Settings --}}
                <a href="{{ route('business.settings') }}"
                    class="sidebar-link {{ request()->routeIs('business.settings') ? 'sidebar-link-active' : '' }}">
                    <i data-lucide="settings" class="w-4 h-4 text-white"></i>
                    <span>Settings</span>
                </a>


                   {{-- Settings --}}
                <a href="{{ route('business.settings') }}"
                    class="sidebar-link {{ request()->routeIs('business.settings') ? 'sidebar-link-active' : '' }}">
                    <i data-lucide="circle-dollar-sign" class="w-4 h-4 text-white"></i>
                    <span>Subscription</span>
                </a>


                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-blue-900">
                    <a href="/support.html"
                        class="flex items-center space-x-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg px-3 py-2 transition-colors no-underline">
                        <i data-lucide="ticket" class="w-5 h-5 text-white"></i>
                        <span class="text-sm font-medium">Raise a Ticket</span>
                    </a>
                </div>

                <div class="w-full mx-auto p-4 bg-green-600 rounded-xl shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-xl">
{{-- Blade variables for dynamic content and styling --}}
@php
// Fallback to "Basic Tier" if activeSubscription is not provided
$activeSubscription = $activeSubscription ?? 'Basic Tier';
$displayactiveSubscription = $activeSubscription;

    // Determine which SVG icon to use based on the plan name
    $isPro = str_contains(strtolower($activeSubscription), 'pro');

    // SVG code for the icon
    if ($isPro) {
        // Zap icon for Pro plans
        $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>';
    } else {
        // Package icon for standard plans
        $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 16-7-10-7 10"/><path d="M12 16v6"/></svg>';
    }
@endphp

<div class="flex items-center space-x-4">
    
    {{-- Plan Icon Container (Deep Blue Accent using bg-blue-700) --}}
    <div class="flex-shrink-0 p-3 rounded-full bg-blue-700/10 text-white transition-transform duration-300">
        <span class="w-6 h-6 inline-block" aria-hidden="true">
            {!! $iconSvg !!}
        </span>
    </div>

    {{-- Plan Details --}}
    <div class="flex flex-col truncate">
        <p class="text-xs font-semibold uppercase tracking-wider text-white">
            Your Current Plan
        </p>
        <h2 class="text-xl font-extrabold text-white leading-tight truncate">
            {{ $displayactiveSubscription }}
        </h2>
    </div>

</div>

{{-- Call to Action --}}
<div class="mt-4 pt-3 border-t border-gray-100">
    {{-- In a real Laravel app, this link would go to your billing route --}}
    <a 
      href="" 
      class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200"
      aria-label="Manage your subscription plan"
    >
      Manage Subscription →
    </a>
</div>

</div>

            </div>
    </div>
    </nav>

</div>