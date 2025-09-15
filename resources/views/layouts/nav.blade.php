<header class=" border-b bg-white border-gray-200 dark:border-gray-700 dark:bg-gray-800  px-4 py-3 flex items-center sticky top-0 z-40" x-data="{ sidebarOpen: false, quickAccessOpen: false, notificationOpen: false }"
    @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true">

    <!-- Mobile Menu Button -->
    <button class="lg:hidden p-2 rounded-md  dark:hover:bg-gray-700 transition-colors" id="menuBtn">
        <i data-lucide="menu"></i>
    </button>

    <!-- Clock -->
    <div class="hidden md:flex items-center space-x-2 bg-blue-50 dark:bg-gray-800  rounded-lg px-3 py-2 ml-4">
        <i data-lucide="clock" class="w-4 h-4 text-blue-600 dark:text-white"></i>
        <div class="text-sm font-medium text-blue-600 dark:text-white" id="clockDisplay">--:--:--</div>
    </div>

    <!-- Right Section -->
    <div class="ml-auto flex items-center space-x-4 relative">

        <!-- Quick Access -->
        <div class="relative" x-data="{ quickAccessOpen: false }" @click.away="quickAccessOpen = false"
           >

            <!-- Button -->
            <button class="p-2 rounded-lg  dark:hover:bg-gray-700 transition-colors bg-blue-50 dark:bg-gray-800 "
                @click="quickAccessOpen = !quickAccessOpen">
                <i data-lucide="zap" class="w-5 h-5"></i>
            </button>

            <!-- Dropdown -->
            <div x-show="quickAccessOpen" x-transition x-cloak
                class="absolute right-0 top-full mt-2 w-64    rounded-lg shadow-lg border bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-800 z-50">
                <div class="p-4">
                    <h3 class=" mb-3">Quick Access</h3>
                    <div class="space-y-2">
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            <span class="text-sm">Add Sale</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span class="text-sm">Add Customer</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="building-2" class="w-4 h-4"></i>
                            <span class="text-sm">Add Supplier</span>
                        </a>
                       
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="folder-plus" class="w-4 h-4"></i>
                            <span class="text-sm">Add Category</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="package-plus" class="w-4 h-4"></i>
                            <span class="text-sm">Add Product</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            <span class="text-sm">Add Sales</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                            <span class="text-sm">Add Purchase</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="folder" class="w-4 h-4"></i>
                            <span class="text-sm">Add Expense Category</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                            <span class="text-sm">Add Expense</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 px-3 py-2 rounded-md  ">
                            <i data-lucide="circle-dollar-sign" class="w-4 h-4"></i>
                            <span class="text-sm">Add Currency</span>
                        </a>
                      
                    </div>

                </div>
            </div>
        </div>


        <!-- Notifications -->
        <div class="relative" @click.away="notificationOpen = false">
            <button class="p-2 rounded-lg  dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors"
                @click="notificationOpen = !notificationOpen">
                <i data-lucide="bell"></i>
                <span
                    class="absolute -top-1 -right-1 bg-red-500  text-xs px-1.5 py-0.5 rounded-full leading-none">3</span>
            </button>
            

            <div x-show="notificationOpen" x-transition x-cloak
                class="absolute right-0 top-full mt-2 w-80 rounded-xl shadow-xl border bg-white  border-gray-200 dark:bg-gray-800 dark:border-gray-800 z-50 p-4"
                @click.away="notificationOpen = false">

                <div class="flex items-center gap-3">
                    <label for="toggleSound" class="text-sm font-medium ">Alert Sound</label>

                    <button id="toggleSound" type="button"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none"
                        role="switch" aria-checked="true">
                        <span aria-hidden="true"
                            class="inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out translate-x-5"
                            id="toggleThumb"></span>
                    </button>
                </div>

                <h3 class="text-sm text-center font-semibold mb-4"></h3>

                <p class="text-center">No Notifications Found</p>

                {{-- <ul class="space-y-4 text-sm  max-h-80 overflow-y-auto">
                    <li class="flex items-start space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 ">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="font-semibold ">Application Error</p>
                            <p class="text-xs ">Just now</p>
                        </div>
                    </li>
                    <li class="flex items-start space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-400 ">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="font-semibold ">Settings</p>
                            <p class="text-xs ">Private message</p>
                        </div>
                    </li>
                    <li class="flex items-start space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-500 ">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="font-semibold ">New user registration</p>
                            <p class="text-xs ">2 days ago</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-4 flex items-center justify-between border-t pt-3">
                    <button class="text-sm text-blue-600 hover:underline font-medium"
                        @click="alert('Marking all as read...')">Mark all as read</button>
                    <button class="text-sm text-red-500 hover:underline font-medium"
                        @click="alert('Clearing notifications...')">Clear all</button>
                </div> --}}
            </div>
        </div>

        <!-- Profile  -->
        <div x-data="{ open: false, showLogoutModal: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-3 pl-2 focus:outline-none">

                <div class="hidden md:flex flex-col">
                    <span class="text-sm font-medium  capitalize">
                        {{ ucfirst(strtolower(auth()->user()->business->name)) }}
                    </span>

                </div>
                <svg class="w-4 h-4 text-gray-300 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Profile Dropdown -->
            <div x-show="open" @click.away="open = false" x-transition x-cloak
                class="absolute right-0 mt-4 w-48 rounded-md shadow-lg bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-800 z-50">
                <a href="#" class="block px-4 py-2 text-sm ">Profile
                    Settings</a>
                <button @click="showLogoutModal = true; open = false"
                    class="w-full text-left px-4 py-2 text-sm ">Logout</button>
            </div>

            <!-- Logout Modal -->
            <div x-show="showLogoutModal" x-transition x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="rounded-lg shadow-lg bg-white w-full max-w-sm p-6" @click.away="showLogoutModal = false">
                    <h2 class="text-lg font-semibold text-gray-600">Confirm Logout</h2>
                    <p class="text-sm text-gray-600 mt-2">Are you sure you want to logout?</p>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button @click="showLogoutModal = false"
                            class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-800  rounded">Cancel</button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700  rounded">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            
        </div>

    </div>
</header>
