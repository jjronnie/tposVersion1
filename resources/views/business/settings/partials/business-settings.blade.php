<div x-show="activeTab === 'Business'"
    class=" mx-auto rounded-lg shadow p-6 space-y-6 bg-white text-gray-900 transition-colors">
    <h1 class="text-2xl font-bold mb-4">Business Settings </h1>
    <p>Account Number: <span class="font-semibold">{{ $business->account_number ?? 'N/A' }}</span></p>

    <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Display a general error message if validation fails --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            {{-- Optionally list all errors --}}
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Business Name Field --}}
            <div>
                <label class="label">Business Name <span class="text-red-600"> *</span></label>
                <input type="text" name="name" value="{{ old('name', $business->name) }}" required
                    class="input @error('name') border-red-500 @enderror" />
                @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Short Name Field --}}
            <div>
                <label class="label">Short Name<span class="text-red-600"> *</span></label>
                <input type="text" name="short_name" value="{{ old('short_name', $business->short_name) }}"
                    class="input @error('short_name') border-red-500 @enderror" required />
                @error('short_name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Business Email Field --}}
            <div>
                <label class="label">Business Email</label>
                <input type="email" name="email" value="{{ old('email', $business->email) }}"
                    class="input @error('email') border-red-500 @enderror" />
                @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Business Phone Number Field --}}
            <div>
                <label class="label">Business Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $business->phone) }}"
                    class="input @error('phone') border-red-500 @enderror" />
                @error('phone')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Currency Field --}}
            <div>
                <label class="label">Currency <span class="text-red-600"> *</span></label>
                <input type="text" name="currency" value="{{ old('currency', $business->currency) }}" required
                    class="input @error('currency') border-red-500 @enderror" />
                @error('currency')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Currency Symbol Field --}}
            <div>
                <label class="label">Currency Symbol<span class="text-red-600"> *</span></label>
                <input type="text" name="currency_symbol"
                    value="{{ old('currency_symbol', $business->currency_symbol) }}" required
                    class="input @error('currency_symbol') border-red-500 @enderror" />
                @error('currency_symbol')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Time Zone Field (Select) --}}
            <div>
                <label class="label">Time Zone <span class="text-red-600"> *</span></label>
                <select name="timezone" required class="input @error('timezone') border-red-500 @enderror">
                    @foreach (timezones() as $value => $timezone)
                    <option value="{{ $value }}" {{ old('timezone', $business->timezone) == $value ? 'selected' : '' }}>
                        {{ $timezone }}
                    </option>
                    @endforeach
                </select>
                @error('timezone')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Country Field (Select) --}}
            <div>
                <label class="label">Country</label>
                <select name="country" class="input @error('country') border-red-500 @enderror">
                    @foreach (countries() as $code => $country)
                    <option value="{{ $code }}" {{ old('country', $business->country) == $code ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                    @endforeach
                </select>
                @error('country')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tax Identification Number Field --}}
            <div>
                <label class="label">Tax Identification Number</label>
                <input type="text" name="tin_no" value="{{ old('tin_no', $business->tin_no) }}"
                    placeholder="Enter TIN Number" class="input @error('tin_no') border-red-500 @enderror" />
                @error('tin_no')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div> {{-- End grid --}}

        {{-- Business Address Field (Textarea) --}}
        <div>
            <label for="address" class="label">Business Address</label>
            <textarea name="address" rows="3" class="placeholder @error('address') border-red-500 @enderror"
                placeholder="Enter your business address here...">{{ old('address', $business->address) }}</textarea>
            @error('address')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Business Logo Field (File Input) --}}
        <div>
            <label class="label">Business Logo</label>
            <div class="mt-1 flex items-center">
                @if ($business->logo_path)
                <img src="{{ asset('storage/' . $business->logo_path) }}"
                    class="h-20 w-20 rounded border border-gray-300 mr-4 object-cover" />
                @endif
                <input type="file" name="logo" class="block text-sm text-gray-900" />
            </div>
            @error('logo')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="btn">
                Save Changes
            </button>
        </div>
    </form>
</div>