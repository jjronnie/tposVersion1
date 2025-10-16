<x-app-layout>
    <x-page-title title="User Details For {{ $user->name }}" />

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('users.index') }}" 
                   class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" 
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                    Back to Users
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-24"></div>
                        <div class="px-6 pb-6">
                            <div class="flex flex-col items-center -mt-12">
                                @if ($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                         alt="{{ $user->name }}"
                                         class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gray-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" viewBox="0 0 24 24" 
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                
                                <!-- Status Badge -->
                                <div class="mt-3">
                                    @if ($user->status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" 
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                <path d="m9 11 3 3L22 4"/>
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" 
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="m15 9-6 6"/>
                                                <path d="m9 9 6 6"/>
                                            </svg>
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Edit Button -->
                                <div class="mt-6 w-full">
                                    <a href="{{ route('users.edit', $user) }}" 
                                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" 
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                            <path d="m15 5 4 4"/>
                                        </svg>
                                        Edit User
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Roles & Permissions Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 24 24" 
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            Roles & Permissions
                        </h3>

                        <div class="space-y-4">
                            <!-- Roles -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Roles</p>
                                @if ($user->roles->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">No roles assigned</p>
                                @endif
                            </div>

                            <!-- Permissions -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Permissions</p>
                                @if ($user->permissions->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($user->permissions as $permission)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">No direct permissions assigned</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details Cards -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 24 24" 
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 2v4M8 2v4"/>
                                <rect width="18" height="18" x="3" y="4" rx="2"/>
                                <path d="M3 10h18"/>
                            </svg>
                            Contact Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if ($user->email_verified_at)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-0.5" viewBox="0 0 24 24" 
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m9 11 3 3L22 4"/>
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" viewBox="0 0 24 24" 
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m3 3 18 18"/>
                                            <path d="M10.584 10.587a2.982 2.982 0 0 0 4.396 4.396"/>
                                            <path d="M9.363 5.365A9.466 9.466 0 0 1 12 5c4 0 7.333 2.333 10 7-.778 1.361-1.612 2.524-2.503 3.488m-2.14 1.861C15.726 18.449 13.942 19 12 19c-4 0-7.333-2.333-10-7 1.369-2.395 2.913-4.175 4.632-5.341"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email Verified</p>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if ($user->email_verified_at)
                                            <span class="text-green-600 font-medium">Verified</span>
                                            <span class="text-gray-500"> - {{ $user->email_verified_at->format('M d, Y') }}</span>
                                        @else
                                            <span class="text-red-600 font-medium">Not Verified</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 20a6 6 0 0 0-12 0"/>
                                        <circle cx="12" cy="10" r="4"/>
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Signup Method</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->signup_method) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business & Account Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 24 24" 
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h18"/>
                                <path d="M9 8h1"/>
                                <path d="M9 12h1"/>
                                <path d="M9 16h1"/>
                                <path d="M14 8h1"/>
                                <path d="M14 12h1"/>
                                <path d="M14 16h1"/>
                                <path d="M6 4v17"/>
                                <path d="M18 4v17"/>
                                <path d="M6 4h12"/>
                            </svg>
                            Business & Account Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                        <polyline points="3.29 7 12 12 20.71 7"/>
                                        <line x1="12" x2="12" y1="22" y2="12"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Business</p>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if ($user->business)
                                            {{ $user->business->name ?? 'N/A' }}
                                        @else
                                            <span class="text-gray-500 italic">Not assigned</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <line x1="19" x2="19" y1="8" y2="14"/>
                                        <line x1="22" x2="16" y1="11" y2="11"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</p>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if ($user->creator)
                                            {{ $user->creator->name }}
                                        @else
                                            <span class="text-gray-500 italic">System</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M8 2v4"/>
                                        <path d="M16 2v4"/>
                                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                                        <path d="M3 10h18"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" 
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Sessions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 24 24" 
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2"/>
                                <path d="M9 3v18"/>
                                <path d="M9 9h12"/>
                                <path d="M9 15h12"/>
                            </svg>
                            Active Sessions
                        </h3>

                        @if (is_array($user->allSessions) && count($user->allSessions) > 0)
                            <div class="space-y-3">
                                @foreach ($user->allSessions as $session)
                                    <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" 
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect width="16" height="20" x="4" y="2" rx="2" ry="2"/>
                                                <path d="M12 18h.01"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $session['agent']['platform'] ?? 'Unknown' }} - {{ $session['agent']['browser'] ?? 'Unknown' }}
                                                </p>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            </div>
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" 
                                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                                                    <path d="M2 12h20"/>
                                                </svg>
                                                IP: {{ $session['ip_address'] }}
                                                <span class="mx-2">•</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" 
                                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                                {{ \Carbon\Carbon::createFromTimestamp($session['last_active'])->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" 
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                    <line x1="2" x2="22" y1="2" y2="22"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No active sessions found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>