<x-app-layout>

    <div x-data="{ activeTab: 'Business' }" class="min-h-screen bg-gray-50 flex flex-col md:flex-row">
        <aside class="w-full md:w-64 bg-white border-r border-gray-200">
            <nav class="flex flex-col p-4 space-y-2">
                <h2 class="text-lg font-semibold mb-4">Settings</h2>

                <a @click.prevent="activeTab = 'Business'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Business'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-warehouse"></i> Business Settings
                </a>

                <a @click.prevent="activeTab = 'Profile'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Profile'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-user"></i> Profile
                </a>


                <a @click.prevent="activeTab = 'Roles & Permissions'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Roles & Permissions'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-user-shield"></i> Role & Permissions
                </a>
                <a @click.prevent="activeTab = 'Taxes'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Taxes'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-calendar"></i> Taxes
                </a>
                <a @click.prevent="activeTab = 'Currencies'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Currencies'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-coins"></i> Currencies
                </a>
                <a @click.prevent="activeTab = 'Payment Modes'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Payment Modes'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-credit-card"></i> Payment Modes
                </a>
                <a @click.prevent="activeTab = 'Units'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Units'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-ruler"></i> Units
                </a>
                <a @click.prevent="activeTab = 'Custom Fields'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Custom Fields'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-pencil-alt"></i> Custom Fields
                </a>
                <a @click.prevent="activeTab = 'Email Settings'" href="#"
                    :class="{
                        'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600': activeTab === 'Email Settings'
                    }"
                    class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-envelope"></i> Email Settings
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6 bg-gray-50">


            {{-- Business Settings --}}

            @include('business.settings.partials.business-settings')

        




            <div x-show="activeTab === 'Profile'" class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Profile</h1>
                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" value="{{ $user->name }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" value="{{ $user->email }}" disabled
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm sm:text-sm" />
                        </div>
                    </div>

                       <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" value="{{ $user->phone }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>



                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" placeholder="Please Enter Password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        <p class="text-xs text-gray-500 mt-1">Leave blank if you don't want to update password.</p>
                    </div>

                 

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Image</label>
                        <div class="mt-1 flex items-center">
                            <span
                                class="inline-block h-20 w-20 rounded border border-gray-300 text-gray-400  items-center justify-center cursor-pointer hover:bg-gray-50">
                                <span>+</span>
                            </span>
                            <p class="ml-4 text-sm text-gray-500">Upload your profile image</p>
                        </div>
                    </div>

                    <div class="pt-4">

                        <button type="submit" class="btn">
                            Save Changes <i data-lucide="save" class="w-5 h-5 ml-2 text-white"></i>
                        </button>

                    </div>
                </form>
            </div>



            <div x-show="activeTab === 'Roles & Permissions'"
                class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Roles & Permissions</h1>
                <p>Content for the Roles & Permissions tab.</p>
            </div>
            <div x-show="activeTab === 'Taxes'" class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Taxes</h1>
                <p>Content for the Taxes tab.</p>
            </div>
            <div x-show="activeTab === 'Currencies'"
                class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Currencies</h1>
                <p>Content for the Currencies tab.</p>
            </div>
            <div x-show="activeTab === 'Payment Modes'"
                class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Payment Modes</h1>
                <p>Content for the Payment Modes tab.</p>
            </div>
            <div x-show="activeTab === 'Units'" class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Units</h1>
                <p>Content for the Units tab.</p>
            </div>
            <div x-show="activeTab === 'Custom Fields'"
                class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Custom Fields</h1>
                <p>Content for the Custom Fields tab.</p>
            </div>
            <div x-show="activeTab === 'Email Settings'"
                class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Email Settings</h1>
                <p>Content for the Email Settings tab.</p>
            </div>
        </main>
    </div>


</x-app-layout>
