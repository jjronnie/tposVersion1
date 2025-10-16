<x-app-layout>
    <x-page-title title="Edit User Details For {{ $user->name }}" />


        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Business -->
        <div>
            <label for="business_id" class="label">Business <span class="text-red-600">*</span></label>
            <select name="business_id" id="business_id" class="input" required>
                @foreach ($businesses as $business)
                    <option value="{{ $business->id }}" {{ $user->business_id == $business->id ? 'selected' : '' }}>
                        {{ $business->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Created By -->
        <div>
            <label for="created_by" class="label">Created By</label>
            <select name="created_by" id="created_by" class="input">
                <option value="">None</option>
                @foreach ($creators as $creator)
                    <option value="{{ $creator->id }}" {{ $user->created_by == $creator->id ? 'selected' : '' }}>
                        {{ $creator->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="label">Full Name <span class="text-red-600">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                class="input @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="label">Email <span class="text-red-600">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                class="input @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="label">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                class="input @error('phone') border-red-500 @enderror">
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="label">Account Status</label>
            <select name="status" id="status" class="input">
                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                <option value="disabled" {{ $user->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>

        <!-- Verification -->
        <div>
            <label for="verified" class="label">Email Verified</label>
            <select name="verified" id="verified" class="input">
                <option value="1" {{ $user->email_verified_at ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$user->email_verified_at ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <!-- Profile Photo -->
        <div>
            <label for="profile_photo_path" class="label">Profile Photo</label>
            <input type="file" name="profile_photo_path" id="profile_photo_path" accept="image/*" class="input">
            @if ($user->profile_photo_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="w-16 h-16 rounded-full">
                </div>
            @endif
        </div>

        <!-- Signup Method -->
        <div>
            <label for="signup_method" class="label">Signup Method</label>
            <input type="text" name="signup_method" id="signup_method"
                value="{{ old('signup_method', $user->signup_method) }}" readonly class="input bg-gray-100">
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="label">New Password</label>
            <input type="password" name="password" id="password" class="input"
                placeholder="Leave blank to keep existing password">
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="label">Role</label>
            <select name="role" id="role" class="input">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex justify-start space-x-3 mt-6">
        <button type="submit" class="btn">
            Save Changes <i data-lucide="save" class="w-4 h-4 ml-2"></i>
        </button>
    </div>
</form>


</x-app-layout>