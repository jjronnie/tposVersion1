<x-slide-form button-icon="eye" title="  {{ $product->name }}">

    <div class="flex items-center space-x-4">

        {{-- Product Image Container --}}
        <div class="profile-image-placeholder">

            <img src="{{ $product->avatar ? asset('storage/' . $product->avatar) : asset('default-avatar.png') }}"
                alt="{{ $product->name }}" class="w-full h-full object-cover">


        </div>

        {{-- Inventory Status Message --}}
        <div class="flex items-center gap-2 flex-grow">
            @if ($product->type === 'service')
            {{-- Service: N/A --}}
            <span class="px-3 py-1 text-sm font-semibold rounded-lg bg-gray-100 text-gray-600">
                Service Item (No Stock Tracking)
            </span>

            @elseif ($product->quantity === 0)
            {{-- Out of Stock --}}
            <span class="px-3 py-1 text-sm font-semibold rounded-lg bg-red-100 text-red-800">
                Product is Out of Stock! Please take action.
            </span>

            @elseif ($product->quantity <= $product->quantity_alert)
                {{-- Low on Stock --}}

                <span class="flex px-3 py-1 text-sm font-semibold rounded-lg bg-yellow-100 text-yellow-800">
                    Stock is Running Low! {{ $product->quantity }} remaining. Alert is set at {{
                    $product->quantity_alert }}.
                </span>

                @else
                {{-- In Stock --}}
                <span class="px-3 py-1 text-sm font-semibold rounded-lg bg-green-100 text-green-800">
                    Product is In Stock: {{ $product->quantity }} available.
                </span>
                @endif
        </div>

{{-- Barcode Image (Optional) --}}
@if ($product->barcode_image_path)
    <div class="mt-6">
        <span class="info-label block mb-2 font-semibold">Barcode Image:</span>
        <img src="{{ asset('storage/' . $product->barcode_image_path) }}" alt="Barcode for {{ $product->name }}" class="w-48 h-auto border p-2 rounded-md">
    </div>
@endif


    </div>

 <div class="info-grid mt-6 border-t pt-6">

    {{-- General Details --}}
    <div class="info-item">
        <span class="info-label">Name :</span>
        <span class="info-value">{{ $product->name }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Type :</span>
        <span class="info-value">{{ ucfirst($product->type) }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Status :</span>
        <span class="info-value">
            @if ($product->is_active)
                <span class="text-green-600 font-medium">Active</span>
            @else
                <span class="text-gray-500 font-medium">Inactive</span>
            @endif
        </span>
    </div>
 

    {{-- Pricing --}}
    <div class="info-item">
        <span class="info-label">Purchase Price :</span>
        <span class="info-value font-semibold">  {{ business_currency() }}  {{ number_format($product->purchase_price, 2) }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Selling Price :</span>
        <span class="info-value ">  {{ business_currency() }}  {{ number_format($product->selling_price, 2) }}</span>
    </div>
    
    {{-- Inventory --}}
    @if ($product->type === 'product')
        <div class="info-item">
            <span class="info-label">Current Stock :</span>
            <span class="info-value">{{ number_format($product->quantity) }} {{ $product->unit ?? 'Units' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Low Stock Alert :</span>
            <span class="info-value">{{ number_format($product->quantity_alert) }} {{ $product->unit ?? 'Units' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Unit of Measure :</span>
            <span class="info-value">{{ $product->unit ?? 'N/A' }}</span>
        </div>
    @endif

    {{-- Auditing/Timestamps --}}
    <div class="info-item">
        <span class="info-label">Created By :</span>
        {{-- Check for creator relationship (assuming you set it up to link to the User model) --}}
        <span class="info-value">{{ $product->creator->name ?? 'System' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Created At :</span>
        <span class="info-value">{{ $product->created_at->format('M d, Y H:i A') }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Last Updated :</span>
        <span class="info-value">{{ $product->updated_at->format('M d, Y H:i A') }}</span>
    </div>

    
</div>

{{-- Description (usually needs full width) --}}
<div class="mt-6 p-4 border rounded-lg bg-gray-50">
    <span class="info-label block mb-2 font-semibold text-lg">Description:</span>
    <p class="text-gray-700 whitespace-pre-wrap">{{ $product->description ?? 'No description provided.' }}</p>
</div>




</x-slide-form>