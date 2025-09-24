<x-slide-form button-icon="plus" title="Add New User">

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

             <div>
                <label class="label">Role <span class="text-red-600"> *</span></label>
                <input type="text" name="role" value="" required class="input" />
            </div>

            <x-form-input label=" Name" name="name" placeholder="Enter Full Name" required />
            <x-form-input label="Email" name="email" placeholder="Enter Email" type="email" required />
            <x-form-input label="Phone Number " name="phone" placeholder="Enter Phone Number " type="text" required />

          

       


            <div>
                <label class="label">Status </label>
                <input type="text" name="phone" value="" required class="input" />
            </div>

             <div>
                <label class="label">Password </label>
                <input type="text" name="phone" value="" required class="input" />
            </div>

        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-3">

            <!-- Confirmation Checkbox -->
            <x-confirmation-checkbox />

            <button type="submit" class="btn">
                Save <i data-lucide="save" class="w-4 h-4 ml-2"></i>
            </button>
        </div>

    </form>
</x-slide-form>