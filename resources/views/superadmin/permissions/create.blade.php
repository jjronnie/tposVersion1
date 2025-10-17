<x-slide-form button-icon="plus" title="Add New Permission">




    <form action="{{ route('superadmin.permissions.store') }}" method="POST">
        @csrf


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4  ">

            <div>
                <label for="name" class="label">Permission Name <span class="text-red-600"> *</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
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