<x-app-layout>
    <x-page-title title="Users" />

    <!-- Controls -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>

                <input type="text" id="searchInput"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Search by name...">


            </div>

        </div>
        <div class="flex gap-3">

            <a class="btn" href="{{ route('users.create') }}"> <i data-lucide="plus" class="w-4 h-4 "></i></a>

            <!-- Export to PDF Button -->
            <button class="btn">
                <i data-lucide="file-text" class="w-4 h-4 "></i>
            </button>


            <!-- Export to Excel Button -->
            <button class="btn">
                <i data-lucide="sheet" class="w-4 h-4 "></i>
            </button>
        </div>

    </div>

    <!-- Table -->
    <x-table :headers="['#', 'User', 'Contact', 'Status', 'Create Date']" showActions="false">
        @foreach ($users as $index => $user)
        <x-table.row>
            <x-table.cell>{{ $index + 1 }}</x-table.cell>
            <x-table.cell>
                <div class="flex items-center">
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->name ?? '' }}</div>
                        <div class="text-sm text-gray-500">{{ ucfirst($user->roles->pluck('name')->implode(', ')) }}
                        </div>
                    </div>
                </div>
            </x-table.cell>


            <x-table.cell>
                <div class="flex items-center">
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->email ?? '' }}</div>
                        <div class="text-sm text-gray-500">{{ $user->phone ?? '' }}</div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell>

                <x-status-badge :status="$user->status" />
            </x-table.cell>
            <x-table.cell>{{ $user->created_at ?? '' }}</x-table.cell>
            <x-table.cell>

                <div class="flex space-x-2">
                <x-slide-form button-icon="eye" title="{{ $user->name }}">
                    <div class="space-y-4 p-4">
                        <h3 class="font-bold text-lg">User Details</h3>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($user->status) }}</p>
                        <p><strong>Role:</strong> {{ $user->roles->pluck('name')->implode(', ') }}</p>
                        <p><strong>Permissions:</strong> {{ $user->permissions->pluck('name')->implode(', ') }}</p>

                        @if ($user->profile_photo_path)
                        <div class="mt-4">
                            <p><strong>Profile Photo:</strong></p>
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo"
                                class="w-24 h-24 object-cover rounded-full mt-2">
                        </div>
                        @endif

                        <h3 class="font-bold text-lg mt-6">Active Sessions</h3>
                        @if (is_array($user->allSessions))
                        @foreach ($user->allSessions as $session)
                        <div class="border p-2 rounded">
                            <p><strong>Device:</strong> {{ $session['agent']['platform'] ?? 'Unknown' }} - {{
                                $session['agent']['browser'] ?? 'Unknown' }}</p>
                            <p><strong>IP Address:</strong> {{ $session['ip_address'] }}</p>
                            <p><strong>Last Active:</strong> {{
                                Carbon\Carbon::createFromTimestamp($session['last_active'])->diffForHumans() }}</p>
                        </div>
                        @endforeach
                        @else
                        <p>No active sessions found.</p>
                        @endif

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('users.edit', $user) }}" class="btn ">
                                Edit User
                            </a>
                        </div>
                    </div>
                </x-slide-form>

                <a href="{{ route('users.edit', $user) }}" class="btn ">
                    <i data-lucide="edit" class="w-4 h-4 "></i>
                </a>
                    <x-confirm-modal :action="route('users.destroy', $user->id)"
                        warning="Are you sure you want to delete this user? This action cannot be undone."
                           triggerIcon="trash" />
                </div>
            </x-table.cell>
        </x-table.row>
        @endforeach
    </x-table>
</x-app-layout>