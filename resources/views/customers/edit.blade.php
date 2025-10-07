<x-app-layout>

    <x-page-title title="Update Customer" subtitle="Edit details of the customer" />

    <div class="rounded-lg shadow p-6 space-y-6 mt-4 bg-white text-gray-900 transition-colors">

        <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Customer Name --}}
                <x-form-input label="Name" value="{{ old('name', $customer->name) }}" name="name"
                    placeholder="Enter Customer Name" required />

                {{-- Customer Email --}}
                <x-form-input label="Email" type="email" value="{{ old('email', $customer->email) }}" name="email"
                    placeholder="Enter Customer email" />

                {{-- Customer Phone --}}
                <x-form-input label="Phone Number" value="{{ old('phone', $customer->phone) }}" name="phone"
                    placeholder="Enter Customer Phone" />

                {{-- TIN Number --}}
                <x-form-input label="TIN Number" value="{{ old('tin_number', $customer->tin_number) }}"
                    name="tin_number" placeholder="Enter TIN Number" />

                {{-- Avatar --}}
                <x-form-input label="Avatar" type="file" name="avatar" />

                {{-- Status --}}
                <div>
                    <label for="status" class="label">Status</label>
                    <select name="status" id="status" class="form-select w-full border rounded-lg p-2">
                        <option value="enabled" {{ old('status', $customer->status) == 'enabled' ? 'selected' : ''
                            }}>Enabled</option>
                        <option value="disabled" {{ old('status', $customer->status) == 'disabled' ? 'selected' : ''
                            }}>Disabled</option>
                    </select>
                </div>

                {{-- Customer Address --}}
                <div>
                    <label for="address" class="label"> Address</label>
                    <textarea name="address" rows="3" class="placeholder w-full border rounded-lg p-2"
                        placeholder="Enter address here...">{{ old('address', $customer->address) }}</textarea>
                </div>

            </div>

            <div class="flex justify-end space-x-3 mt-4">
                <x-confirmation-checkbox />
                <button type="submit" class="btn">
                    Update <i data-lucide="save" class="w-4 h-4 ml-2"></i>
                </button>
            </div>
        </form>

    </div>

</x-app-layout>