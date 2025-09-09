confirmation Modal

<x-confirm-modal :action="route('users.destroy', $user->id)" warning="Are you sure you want to delete this user? This action cannot be undone."
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

<x-table :headers="['#']" showActions="false">
    <x-table.row>
        <x-table.cell>1</x-table.cell>


        <x-table.cell>
            <x-dropdown-actions>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-green-600">View</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-blue-600">Edit</a>
            </x-dropdown-actions>
        </x-table.cell>
    </x-table.row>

</x-table>

<x-table :headers="[]" showActions="false">
    <x-table.row>
        <x-table.cell></x-table.cell>
    </x-table.row>
</x-table>





side form-select
<x-slide-form button-text="Settings" title="Settings Form">

</x-slide-form>

<x-slide-form button-text="Settings" title="Settings Form">
    <form method="POST" action="">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name<span class="text-red-600">*</span></label>
                <input type="text" name="name" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name"
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-green-500">
            </div>

        </div>
        <button type="submit" class="btn">
            Save
        </button>
    </form>
</x-slide-form>


<!-- Default -->
<x-confirmation-checkbox />

<!-- Custom text -->
<x-confirmation-checkbox id="agree-terms" name="agree_terms" label="I agree to the Terms & Conditions" color="blue" />
