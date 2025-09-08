    <div x-show="activeTab === 'Business'" class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
                <h1 class="text-2xl font-bold mb-4">Business Settings </h1>
                <p>Account Number: <span class="font-semibold"> {{ $business->account_number ?? 'N/A' }}</span></p>


         <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Business Name *</label>
            <input type="text" name="name" value="{{ old('name', $business->name) }}" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Short Name</label>
            <input type="text" name="short_name" value="{{ old('short_name', $business->short_name) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $business->email) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Business Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone', $business->phone) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Currency *</label>
            <input type="text" name="currency" value="{{ old('currency', $business->currency) }}" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Time Zone *</label>
            <select name="timezone" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @foreach (timezones() as $value => $timezone)
                    <option value="{{ $value }}" {{ old('timezone', $business->timezone) == $value ? 'selected' : '' }}>
                        {{ $timezone }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Country</label>
            <select name="country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @foreach (countries() as $code => $country)
                    <option value="{{ $code }}" {{ old('country', $business->country) == $code ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tax Identification Number</label>
            <input type="text" name="tin_no" value="{{ old('tin_no', $business->tin_no) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Website</label>
            <input type="text" name="website" value="{{ old('website', $business->website) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"/>
        </div>
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Business Address</label>
        <textarea name="address" rows="3"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            placeholder="Enter your business address here...">{{ old('address', $business->address) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Business Logo</label>
        <div class="mt-1 flex items-center">
            @if($business->logo_path)
                <img src="{{ asset('storage/'.$business->logo_path) }}" class="h-20 w-20 rounded border mr-4 object-cover"/>
            @endif
            <input type="file" name="logo" class="block text-sm text-gray-500"/>
        </div>
    </div>

    <div class="pt-4">
        <button type="submit" class="btn">Save Changes <i data-lucide="save" class="w-5 h-5 ml-2 text-white"></i></button>
    </div>
</form>



            </div>