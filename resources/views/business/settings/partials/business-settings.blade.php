<div x-show="activeTab === 'Business'"
    class="max-w-3xl mx-auto rounded-lg shadow p-6 space-y-6 bg-white text-gray-900 transition-colors">
    <h1 class="text-2xl font-bold mb-4">Business Settings </h1>
    <p>Account Number: <span class="font-semibold">{{ $business->account_number ?? 'N/A' }}</span></p>

    <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="label">Business Name <span class="text-red-600"> *</span></label>
                <input type="text" name="name" value="{{ old('name', $business->name) }}" required
                    class="input" />
            </div>

            <div>
                <label class="label">Short Name</label>
                <input type="text" name="short_name" value="{{ old('short_name', $business->short_name) }}"
                    class="input" />
            </div>

            <div>
                <label class="label">Email</label>
                <input type="email" name="email" value="{{ old('email', $business->email) }}"
                    class="input" />
            </div>

            <div>
                <label class="label">Business Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $business->phone) }}"
                    class="input" />
            </div>

            <div>
                <label class="label">Currency <span class="text-red-600"> *</span></label>
                <input type="text" name="currency" value="{{ old('currency', $business->currency) }}" required
                    class="input" />
            </div>

            <div>
                <label class="label">Time Zone <span class="text-red-600"> *</span></label>
                <select name="timezone" required
                    class="input">
                    @foreach (timezones() as $value => $timezone)
                        <option value="{{ $value }}"
                            {{ old('timezone', $business->timezone) == $value ? 'selected' : '' }}>
                            {{ $timezone }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="label">Country</label>
                <select name="country"
                    class="input">
                    @foreach (countries() as $code => $country)
                        <option value="{{ $code }}"
                            {{ old('country', $business->country) == $code ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="label">Tax Identification Number</label>
                <input type="text" name="tin_no" value="{{ old('tin_no', $business->tin_no) }}"
                    class="input" />
            </div>

            <div>
                <label class="label">Website</label>
                <input type="text" name="website" value="{{ old('website', $business->website) }}"
                    class="input" />
            </div>
        </div>

        <div>
            <label for="address" class="label">Business Address</label>
            <textarea name="address" rows="3"
                class="placeholder"
                placeholder="Enter your business address here...">{{ old('address', $business->address) }}</textarea>
        </div>

        <div>
            <label class="label">Business Logo</label>
            <div class="mt-1 flex items-center">
                @if ($business->logo_path)
                    <img src="{{ asset('storage/' . $business->logo_path) }}"
                        class="h-20 w-20 rounded border border-gray-300 mr-4 object-cover" />
                @endif
                <input type="file" name="logo" class="block text-sm text-gray-900" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="btn">
                Save Changes 
            </button>
        </div>
    </form>
</div>
