<x-app-layout>

    <x-page-title />

 <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">

    <x-stat-card title="Total Users" value="{{ $stats['total'] }}" icon="users" />

    <x-stat-card title="Verified" value="{{ $stats['verified'] }}" icon="check-circle" />

    <x-stat-card title="Unverified" value="{{ $stats['unverified'] }}" icon="x-circle" />

    <x-stat-card title="Active" value="{{ $stats['active'] }}" icon="user-check" />

    <x-stat-card title="Suspended" value="{{ $stats['suspended'] }}" icon="user-x" />

    <x-stat-card title="Disabled" value="{{ $stats['disabled'] }}" icon="slash" />

    <x-stat-card title="Email Signups" value="{{ $stats['email_signups'] }}" icon="mail" />

    <x-stat-card title="Google Signups" value="{{ $stats['google_signups'] }}" icon="globe" />

</div>


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
    <x-table :headers="['#', 'User', 'Contact', 'Business', 'Status', 'Create Date']" showActions="false">
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
                {{ $user->business ? $user->business->name : 'N/A' }}
              </x-table.cell>
            <x-table.cell>

                <x-status-badge :status="$user->status" />
            </x-table.cell>
            <x-table.cell>{{ $user->created_at ?? '' }}</x-table.cell>
            <x-table.cell>

                <div class="flex space-x-2">
                  
                     <a href="{{ route('superadmin.users.show', $user) }}" class="btn ">
                        <i data-lucide="eye" class="w-4 h-4 "></i>
                    </a>



                    <a href="{{ route('superadmin.users.edit', $user) }}" class="btn ">
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