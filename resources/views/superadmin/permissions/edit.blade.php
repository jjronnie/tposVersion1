<form action="{{ route('superadmin.permissions.update', $permission->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4  ">

        <div>
            <label for="name" class="label">Permission Name <span class="text-red-600"> *</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" required
                class="input @error('name') border-red-500 @enderror" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>


</form>