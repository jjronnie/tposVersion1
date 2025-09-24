<x-app-layout>

    <x-page-title title="Add New Customer" subtitle="Enter Details to create new customer" />

    <div class="rounded-lg shadow p-6 space-y-6 mt-4 bg-white text-gray-900 transition-colors">

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                <x-form-input label="Name" value="{{ old('name') }}" name="name" placeholder="Enter Customer Name"
                    required />

                <x-form-input label="Email" type="email" value="{{ old('email') }}" name="email"
                    placeholder="Enter Customer email" />

                     <x-form-input label="Phone Number" value="{{ old('phone') }}" name="phone"
                    placeholder="Enter Customer Phone" />
                    


               <div>
            <label for="address" class="label"> Address</label>
            <textarea name="address" rows="3"
                class="placeholder"
                placeholder="Enter  address here...">{{ old('address') }}</textarea>
        </div>

                

            </div>
            <div class="flex justify-end space-x-3">
                <x-confirmation-checkbox />
                <button type="submit" class="btn">
                    Save <i data-lucide="save" class="w-4 h-4 ml-2"></i>
                </button>
            </div>
        </form>

    </div>



</x-app-layout>