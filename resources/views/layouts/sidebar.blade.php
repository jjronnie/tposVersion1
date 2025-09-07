<div class="w-80 lg:w-64 bg-[#001529] text-white flex flex-col fixed top-0 left-0 h-screen z-50 transform transition-transform duration-300 -translate-x-full lg:translate-x-0"
    id="sidebar">
    <!-- Sidebar Header -->

    <div class="p-4 border-b border-blue-900 flex items-center justify-between">
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

            <a href="{{ route('dashboard') }}"
                class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors ">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-white"></i>
                <span>Dashboard</span>
            </a>
            <div class="space-y-1">

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="package" class="w-4 h-4 text-white"></i>
                    <span>Products</span>
                </a>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="shopping-cart" class="w-4 h-4 text-white"></i>
                    <span>Sales</span>
                </a>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="users" class="w-4 h-4 text-white"></i>
                    <span>Customers</span>
                </a>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="truck" class="w-4 h-4 text-white"></i>
                    <span>Purchases</span>
                </a>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="building-2" class="w-4 h-4 text-white"></i>
                    <span>Suppliers</span>
                </a>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="wrench" class="w-4 h-4 text-white"></i>
                    <span>Tools</span>
                </a>

                <a href="{{ route('business.settings') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium ">
                    <i data-lucide="settings" class="w-4 h-4 text-white"></i>
                    <span>Settings</span>
                </a>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 text-white text-sm font-medium">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-white"></i>
                    <span>Statistics</span>
                </a>
            </div>



    </div>
    </nav>






</div>
