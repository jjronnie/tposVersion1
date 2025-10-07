<x-app-layout>
    <x-page-title title="Add New Supplier" />

     <div class="rounded-lg shadow p-6 space-y-6 mt-4 bg-white text-gray-900 transition-colors">

        <form action="{{ route('suppliers.store') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Supplier Name (Required) --}}
        <x-form-input 
            label="Name" 
            value="{{ old('name') }}" 
            name="name"
            placeholder="Enter Supplier Name" 
            required 
        />

        {{-- Supplier Email --}}
        <x-form-input 
            label="Email" 
            type="email" 
            value="{{ old('email') }}" 
            name="email"
            placeholder="Enter Supplier Email" 
        />

        {{-- Supplier Phone --}}
        <x-form-input 
            label="Phone Number" 
            value="{{ old('phone') }}" 
            name="phone"
            placeholder="Enter Supplier Phone" 
        />

        {{-- Contact Person --}}
        <x-form-input 
            label="Contact Person" 
            value="{{ old('contact_person') }}" 
            name="contact_person"
            placeholder="Enter Contact Person's Name" 
        />
        
        {{-- Opening Balance --}}
        <x-form-input 
            label="Opening Balance" 
            type="number" 
            step="0.01"
            value="{{ old('opening_balance', 0.00) }}" 
            name="opening_balance"
            placeholder="0.00" 
        />

        {{-- Tax ID (TIN Number equivalent) --}}
        <x-form-input 
            label="Tax ID" 
            value="{{ old('tax_id') }}"
            name="tax_id" 
            placeholder="Enter Tax ID" 
        />

        {{-- Status --}}
        <div>
            <label for="status" class="label">Status</label>
            <select name="status" id="status" class="form-select w-full border rounded-lg p-2">
                {{-- Default to 'enabled' as per migration schema --}}
                <option value="enabled" {{ old('status', 'enabled') == 'enabled' ? 'selected' : '' }}>
                    Enabled
                </option>
                <option value="disabled" {{ old('status') == 'disabled' ? 'selected' : '' }}>
                    Disabled
                </option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Supplier Address --}}
        <div class="md:col-span-3">
            <label for="address" class="label">Address</label>
            <textarea 
                name="address" 
                rows="3" 
                class="placeholder w-full border rounded-lg p-2"
                placeholder="Enter address here..."
            >{{ old('address') }}</textarea>
            @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Supplier Notes --}}
        <div class="md:col-span-3">
            <label for="notes" class="label">Notes</label>
            <textarea 
                name="notes" 
                rows="3" 
                class="placeholder w-full border rounded-lg p-2"
                placeholder="Any internal notes about the supplier..."
            >{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>

    <div class="flex justify-end space-x-3 mt-4">
        <x-confirmation-checkbox />
        <button type="submit" class="btn">
            Create Supplier <i data-lucide="plus" class="w-4 h-4 ml-2"></i>
        </button>
    </div>
</form>

     </div>

   

</x-app-layout>