<x-app-layout>

    <x-page-title title="Add New User" />
    <div class="rounded-lg shadow p-6 space-y-6 bg-white text-gray-900 transition-colors">

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="label">Role <span class="text-red-600"> *</span></label>
                    <select name="role" required class="input">
                        <option value="">Select a Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <x-form-input label="Name" name="name" placeholder="Enter Full Name"
                    value="{{ old('name', $user->name) }}" required />
                <x-form-input label="Email" name="email" placeholder="Enter Email" type="email"
                    value="{{ old('email', $user->email) }}" required />
                <x-form-input label="Phone Number" name="phone" placeholder="Enter Phone Number" type="text"
                    value="{{ old('phone', $user->phone) }}" />

                <div>
                    <label class="label">Status <span class="text-red-600"> *</span></label>
                    <select name="status" required class="input">
                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="disabled" {{ $user->status === 'disabled' ? 'selected' : '' }}>Disabled</option>
                        <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended
                        </option>
                    </select>
                </div>

                <x-form-input label="New Password (optional)" name="password" type="password"
                    placeholder="Enter a new password" />
                <x-form-input label="Confirm New Password" name="password_confirmation" type="password"
                    placeholder="Confirm new password" />

            </div>

           <div class="mt-4">
    <label class="label">Permissions</label>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
        @foreach($permissions as $permission)
        <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
            <span class="text-sm text-gray-700 font-medium">{{ $permission->name }}</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                       class="sr-only peer"
                       {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
        @endforeach
    </div>
</div>

            <div class="flex justify-end space-x-3">
                <x-confirmation-checkbox />
                <button type="submit" class="btn">
                    Update <i data-lucide="save" class="w-4 h-4 ml-2"></i>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>