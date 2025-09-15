<!-- Floating Quick Access -->
<div class="fixed bottom-6  right-6 z-50" x-data="{ quickAccessOpen: false }" @click.away="quickAccessOpen = false">

    <!-- Floating Button -->
    <button 
        class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-600  shadow-lg hover:bg-blue-700 transition"
        @click="quickAccessOpen = !quickAccessOpen">
        <i data-lucide="plus" class="w-6 h-6"></i>
    </button>

    <!-- Dropdown Menu -->
    <div 
        x-show="quickAccessOpen" 
        x-transition 
        x-cloak
        class="absolute bottom-16 right-0 w-64 rounded-lg shadow-lg border bg-white   dark:bg-gray-800 border-gray-200 dark:border-gray-800">

        <div class="p-4">
            <h3 class="text-sm font-medium  mb-3">Quick Access</h3>
            <div class="space-y-2 max-h-80 overflow-y-auto">
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span class="text-sm">Add Staff Member</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span class="text-sm">Add Customer</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                    <span class="text-sm">Add Supplier</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="bookmark-plus" class="w-4 h-4"></i>
                    <span class="text-sm">Add Brand</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="folder-plus" class="w-4 h-4"></i>
                    <span class="text-sm">Add Category</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="package-plus" class="w-4 h-4"></i>
                    <span class="text-sm">Add Product</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    <span class="text-sm">Add Sale</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="truck" class="w-4 h-4"></i>
                    <span class="text-sm">Add Purchase</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="folder" class="w-4 h-4"></i>
                    <span class="text-sm">Add Expense Category</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    <span class="text-sm">Add Expense</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="circle-dollar-sign" class="w-4 h-4"></i>
                    <span class="text-sm">Add Currency</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="warehouse" class="w-4 h-4"></i>
                    <span class="text-sm">Add Warehouse</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="ruler" class="w-4 h-4"></i>
                    <span class="text-sm">Add Unit</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="languages" class="w-4 h-4"></i>
                    <span class="text-sm">Add Language</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="shield-plus" class="w-4 h-4"></i>
                    <span class="text-sm">Add Role</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="percent" class="w-4 h-4"></i>
                    <span class="text-sm">Add Tax</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span class="text-sm">Add Payment Mode</span>
                </a>
            </div>
        </div>
    </div>
</div>


<footer class=" border-t border-gray-200 dark:bg-gray-800 dark:border-gray-800 py-4">
    <div
        class="max-w-7xl mx-auto px-4 md:px-6 flex flex-col sm:flex-row justify-between items-center text-sm  space-y-2 sm:space-y-0">
        <p>&copy; {{ date('Y') }} Arrow Security Systems. | All rights reserved.</p>

        <p>Version 1.0.0</p>
    </div>
</footer>