<x-app-layout>

    <x-page-title title="Add New Customer" subtitle="Enter Details to create new customer" />

    <div class="rounded-lg shadow p-6 space-y-6 mt-4 bg-white text-gray-900 transition-colors">

       <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <x-form-input label="Name" value="{{ old('name') }}" name="name" placeholder="Enter Customer Name" required />

        <x-form-input label="Email" type="email" value="{{ old('email') }}" name="email" placeholder="Enter Customer email" />

        <x-form-input label="Phone Number" value="{{ old('phone') }}" name="phone" placeholder="Enter Customer Phone" />
        
        <x-form-input label="TIN Number" value="{{ old('tin_number') }}" name="tin_number" placeholder="Enter TIN Number" />
        
        <x-form-input label="Avatar" type="file" name="avatar" />

        <div>
            <label for="status" class="label">Status</label>
            <select name="status" id="status" class="form-select w-full border rounded-lg p-2">
                <option value="enabled" {{ old('status') == 'enabled' ? 'selected' : '' }}>Enabled</option>
                <option value="disabled" {{ old('status') == 'disabled' ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>

        
        <div>
            <label for="address" class="label">Address</label>
            <textarea name="address" rows="3" class="placeholder" placeholder="Enter address here...">{{ old('address') }}</textarea>
        </div>

    </div>
    <div class="flex justify-end space-x-3 mt-6">
        <x-confirmation-checkbox />
        <button type="submit" class="btn">
            Save <i data-lucide="save" class="w-4 h-4 ml-2"></i>
        </button>
    </div>
</form>

    </div>



</x-app-layout>