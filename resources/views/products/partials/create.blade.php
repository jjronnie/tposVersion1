 <x-slide-form button-icon="plus" title="Add New Product">


  <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">

              {{-- 1. Product Name --}}
                <div>
                    <label for="name" class="label">Product Name <span class="text-red-600"> *</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="input @error('name') border-red-500 @enderror"  />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                 {{-- 2. Product Type (Product/Service) --}}
                <div>
                    <label for="type" class="label">Type <span class="text-red-600"> *</span></label>
                    <select name="type" id="type" required class="input @error('type') border-red-500 @enderror">
                        <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Product (Inventory tracked)</option>
                        <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>Service (No inventory)</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

             

            </div>

         


            {{-- ===================================
                SECTION 2: Pricing
            ==================================== --}}
            <h3 class="text-xl font-semibold border-b pb-2 mb-4 text-gray-700">Pricing</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                {{-- 4. Purchase Price --}}
                <div>
                    <label for="purchase_price" class="label">Purchase Price ($) <span class="text-red-600"> *</span></label>
                    <input type="number" step="0.01" min="0" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" required class="input @error('purchase_price') border-red-500 @enderror" placeholder="0.00" />
                    @error('purchase_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 5. Selling Price --}}
                <div>
                    <label for="selling_price" class="label">Selling Price ($) <span class="text-red-600"> *</span></label>
                    <input type="number" step="0.01" min="0" name="selling_price" id="selling_price" value="{{ old('selling_price') }}" required class="input @error('selling_price') border-red-500 @enderror" placeholder="0.00" />
                    @error('selling_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>


            {{-- ===================================
                SECTION 3: Inventory & Media
            ==================================== --}}
            <h3 class="text-xl font-semibold border-b pb-2 mb-4 text-gray-700">Inventory & Media</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- 6. Unit --}}
                <div>
                    <label for="unit" class="label">Unit (e.g., kg, pcs, box)</label>
                    <input type="text" name="unit" id="unit" value="{{ old('unit') }}" class="input @error('unit') border-red-500 @enderror" placeholder="Unit" />
                    @error('unit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 7. Quantity --}}
                <div>
                    <label for="quantity" class="label">Initial Quantity <span class="text-red-600"> *</span></label>
                    <input type="number" min="0" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" required class="input @error('quantity') border-red-500 @enderror" placeholder="0" />
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 8. Quantity Alert --}}
                <div>
                    <label for="quantity_alert" class="label">Low Stock Alert <span class="text-red-600"> *</span></label>
                    <input type="number" min="0" name="quantity_alert" id="quantity_alert" value="{{ old('quantity_alert', 10) }}" required class="input @error('quantity_alert') border-red-500 @enderror" placeholder="10" />
                    @error('quantity_alert')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- 9. Product Avatar/Image --}}
                <div>
                    <label for="avatar" class="label">Product Image (Avatar)</label>
                    <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-primary-50 file:text-primary-700
                        hover:file:bg-primary-100 cursor-pointer
                    " />
                    @error('avatar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                   {{-- Description --}}
            <div class="mb-6">
                <label for="description" class="label">Description (Simple)</label>
                <textarea name="description" id="description" rows="3" class="input @error('description') border-red-500 @enderror" placeholder="A brief description of the product or service.">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            
            </div>



      

        <div class="flex justify-end space-x-3 mt-6">
       
        <button type="submit" class="btn">
            Save <i data-lucide="save" class="w-4 h-4 ml-2"></i>
        </button>
    </div>
    </form>
            
        </x-slide-form>