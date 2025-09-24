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

          @include('users.create')

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
                        <div class="text-sm text-gray-500">{{ ucfirst($user->roles->pluck('name')->implode(', ')) }}</div>
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
                <x-slide-form button-text="View" title="User">
                </x-slide-form>
            </x-table.cell>
        </x-table.row>
        @endforeach
    </x-table>
</x-app-layout>