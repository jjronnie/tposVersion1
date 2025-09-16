<x-app-layout>

    <!-- Page title -->
    <div class="space-y-2">
        <h1 class="text-2xl md:text-2xl font-bold text-gray-900 pb-4 m-0">Users</h1>

    </div>

    <!-- Table -->

    <x-table :headers="['#', 'User', 'Contact', 'Status', 'Create Date']" showActions="false">
        @foreach ($users as $index => $user)
            <x-table.row>
                <x-table.cell>{{ $index + 1 }}</x-table.cell>
                <x-table.cell>{{ $user->name ?? '' }}</x-table.cell>

                <x-table.cell>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $user->email ?? '' }}</div>
                            <div class="text-sm text-gray-500">{{ $user->phone ?? '' }}</div>
                        </div>
                    </div>
                </x-table.cell>

                <x-table.cell>
                    <span
                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                        Active
                    </span>
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
