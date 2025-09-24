<x-app-layout>

    <div x-data="{ activeTab: 'Business' }" class="min-h-screen flex flex-col md:flex-row">
    <aside class="w-full md:w-64 border-r border-gray-200 bg-white">
    <nav class="flex flex-col p-4 space-y-2">
        <h2 class="text-lg font-semibold mb-4">Settings</h2>

        <template x-for="tab in [
            { name: 'Business', icon: 'fas fa-warehouse' },
            { name: 'Profile', icon: 'fas fa-user' },
            { name: 'Roles & Permissions', icon: 'fas fa-user-shield' },
            { name: 'Taxes', icon: 'fas fa-calendar' },
            { name: 'Currencies', icon: 'fas fa-coins' },
            { name: 'Payment Modes', icon: 'fas fa-credit-card' },
            { name: 'Units', icon: 'fas fa-ruler' },
            { name: 'Custom Fields', icon: 'fas fa-pencil-alt' },
            { name: 'Email Settings', icon: 'fas fa-envelope' }
        ]" :key="tab.name">
            <a @click.prevent="activeTab = tab.name" href="#"
               :class="activeTab === tab.name 
                        ? 'bg-blue-600 text-white font-semibold' 
                        : 'text-gray-700 hover:bg-gray-100'"
               class="flex items-center gap-2 p-2 rounded transition-colors">
                <i :class="tab.icon"></i> 
                <span x-text="tab.name"></span>
            </a>
        </template>
    </nav>
</aside>


        <main class="flex-1 p-6 bg-gray-50">


            {{-- Business Settings --}}

            @include('business.settings.partials.business-settings')






            <div x-show="activeTab === 'Profile'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Profile</h1>
                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium ">Name <span class="text-red-500">*</span></label>
                            <input type="text" value="{{ $user->name }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium ">Email <span class="text-red-500">*</span></label>
                            <input type="email" value="{{ $user->email }}" disabled
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm sm:text-sm" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium ">Phone Number</label>
                        <input type="text" value="{{ $user->phone }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>



                    <div>
                        <label class="block text-sm font-medium ">Password</label>
                        <input type="password" placeholder="Please Enter Password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        <p class="text-xs  mt-1">Leave blank if you don't want to update password.</p>
                    </div>



                    <div>
                        <label class="block text-sm font-medium ">Profile Image</label>
                        <div class="mt-1 flex items-center">
                            <span
                                class="inline-block h-20 w-20 rounded border border-gray-300  items-center justify-center cursor-pointer hover:bg-gray-50">
                                <span>+</span>
                            </span>
                            <p class="ml-4 text-sm ">Upload your profile image</p>
                        </div>
                    </div>

                    <div class="pt-4">

                        <button type="submit" class="btn">
                            Save Changes <i data-lucide="save" class="w-5 h-5 ml-2 "></i>
                        </button>

                    </div>
                </form>
            </div>



            <div x-show="activeTab === 'Roles & Permissions'"
                class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Roles & Permissions</h1>
                <p>Content for the Roles & Permissions tab.</p>
            </div>
            <div x-show="activeTab === 'Taxes'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Taxes</h1>
                <p>Content for the Taxes tab.</p>
            </div>
            <div x-show="activeTab === 'Currencies'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Currencies</h1>
                <p>Content for the Currencies tab.</p>
            </div>
            <div x-show="activeTab === 'Payment Modes'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Payment Modes</h1>
                <p>Content for the Payment Modes tab.</p>
            </div>
            <div x-show="activeTab === 'Units'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Units</h1>
                <p>Content for the Units tab.</p>
            </div>
            <div x-show="activeTab === 'Custom Fields'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Custom Fields</h1>
                <p>Content for the Custom Fields tab.</p>
            </div>
            <div x-show="activeTab === 'Email Settings'" class="max-w-3xl mx-auto  rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Email Settings</h1>
                <p>Content for the Email Settings tab.</p>
            </div>
        </main>
    </div>


</x-app-layout>
