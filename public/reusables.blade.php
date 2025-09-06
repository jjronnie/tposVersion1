confirmation Modal

    <x-confirm-modal :action="route('users.destroy', $user->id)"
                        warning="Are you sure you want to delete this user? This action cannot be undone."
                        triggerText="Delete User" />

<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
    <!-- card -->
    <x-stat-card title="" value="" icon="" color="" />

</div>


<!-- dropdown in table -->

<td>
    <x-dropdown-actions>

        <a href="{{ route('employees.show', $employee->id) }}" class="block px-4 py-2 hover:bg-gray-100 text-green-600"
            role="menuitem">View</a>

        <a href="{{ route('employees.edit', $employee->id) }}" class="block px-4 py-2 hover:bg-gray-100 text-blue-600"
            role="menuitem">Edit</a>

    </x-dropdown-actions>
</td>




<!-- Table -->

<x-table :headers="['#', 'ID NO.', 'Employee', 'Department', 'Status', 'Join Date']" showActions="false">
    <x-table.row>
        <x-table.cell>1</x-table.cell>
        <x-table.cell>EMP-001</x-table.cell>

        <x-table.cell>
            <div class="flex items-center">
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">John Doe</div>
                    <div class="text-sm text-gray-500">Full-time</div>
                </div>
            </div>
        </x-table.cell>

        <x-table.cell>Finance</x-table.cell>

        <x-table.cell>
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                Active
            </span>
        </x-table.cell>

        <x-table.cell>Jan 15, 2022</x-table.cell>

        <x-table.cell>
            <x-dropdown-actions>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-green-600">View</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-blue-600">Edit</a>
            </x-dropdown-actions>
        </x-table.cell>
    </x-table.row>

</x-table>
