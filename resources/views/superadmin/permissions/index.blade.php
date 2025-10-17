<x-app-layout>

    <x-page-title />

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

            @include('superadmin.permissions.create')

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



    <x-table :headers="[ '#', 'Permission', 'Users' ,'Actions']">

        @foreach ($permissions as $index => $permission)
        <x-table.row>
            <x-table.cell>{{ $index + 1 }}</x-table.cell>
            <x-table.cell>{{ $permission->name }}</x-table.cell>
            <x-table.cell>{{ $permission->created_at }}</x-table.cell>
            <x-table.cell>
                <div class="flex space-x-2">



                    <x-slide-form button-icon="edit" title="Settings Form">

                        <form action="{{ route('superadmin.permissions.update', $permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4  ">

                                <div>
                                    <label for="name" class="label">Permission Name <span class="text-red-600">
                                            *</span></label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $permission->name) }}" required
                                        class="input @error('name') border-red-500 @enderror" />
                                    @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <div class="flex justify-start space-x-3 mt-6">

                                <button type="submit" class="btn">
                                    Save <i data-lucide="save" class="w-4 h-4 ml-2"></i>
                                </button>
                            </div>


                        </form>

                    </x-slide-form>


                    <x-confirm-modal :action="route('superadmin.permissions.destroy', $permission->id)"
                        warning="Are you sure you want to delete this permission? This action cannot be undone."
                        triggerIcon="trash" />


                </div>
            </x-table.cell>
        </x-table.row>
        @endforeach
    </x-table>

</x-app-layout>