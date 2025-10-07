<x-slide-form button-icon="plus" title="Add New Unit ">

    <form action="{{ route('units.store') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Unit Name (e.g., Kilogram) --}}
        <x-form-input 
            label="Unit Name" 
            value="{{ old('name') }}" 
            name="name"
            placeholder="e.g., Kilogram" 
            required 
        />

        {{-- Short Name (e.g., kg) --}}
        <x-form-input 
            label="Short Name" 
            value="{{ old('short_name') }}" 
            name="short_name"
            placeholder="e.g., kg, Ltr, pcs" 
            required 
        />

        {{-- An empty slot to maintain the grid layout symmetry --}}
        <div></div>

    </div>

    <div class="flex justify-end space-x-3 mt-6">
        <button type="submit" class="btn bg-indigo-600 hover:bg-indigo-700 text-white">
            Create Unit <i data-lucide="save" class="w-4 h-4 ml-2"></i>
        </button>
    </div>
</form>

</x-slide-form>