<x-app-layout>

    <x-page-title />

    <!-- Controls -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>

                <input type="text" id="searchInput"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Search by name...">


            </div>

        </div>
        <div class="flex gap-3">

            @include('products.partials.create')
            <!-- Export to PDF Button -->
            <button class="btn">
                <i data-lucide="file-text" class="w-4 h-4 "></i>
            </button>


            <!-- Export to Excel Button -->
            <button class="btn">
                <i data-lucide="sheet" class="w-4 h-4 "></i>
            </button>
        </div>

    </div>

    @if ($products->isEmpty())


    <x-empty-state message="No products found" />


    @else

    <x-table :headers="[
            '#', 
            'Name', 
            'Type',         
            'Purchase Price', 
            'Selling Price', 
            'Current Stock', 
            'Status', 
            
        ]" showActions="true">

        @foreach ($products as $index => $product)
        {{-- LOW STOCK ALERT: Highlight the row if quantity is at or below the alert level AND it is a product --}}
        <x-table.row
            class="{{ ($product->type === 'product' && $product->quantity <= $product->quantity_alert) ? 'bg-red-50 hover:bg-red-100 transition-colors' : 'hover:bg-gray-50' }}">

              <x-table.cell>  {{ $index + 1 }}</x-table.cell>
            {{-- Name (with Low Stock Icon) --}}
            <x-table.cell class="font-medium text-gray-900">
                {{ $product->name }}
                @if ($product->type === 'product' && $product->quantity <= $product->quantity_alert)
                    <span class="text-red-500 ml-2" title="Low Stock: {{ $product->quantity }} remaining">
                        <i data-lucide="alert-triangle" class="w-4 h-4 inline-block align-text-bottom"></i>
                    </span>
                    @endif
            </x-table.cell>

            {{-- Type (Product/Service) --}}
            <x-table.cell>
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $product->type === 'product' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                    {{ ucfirst($product->type) }}
                </span>
            </x-table.cell>



            {{-- Purchase Price --}}
            <x-table.cell>
              {{ business_currency() }}  {{ number_format($product->purchase_price, 2) }}
            </x-table.cell>

            {{-- Selling Price --}}
            <x-table.cell class="font-semibold">
                {{ business_currency() }}   {{ number_format($product->selling_price, 2) }}
            </x-table.cell>



            <x-table.cell>
                @if ($product->type === 'product')
                {{ $product->quantity }} {{ $product->unit }}
                {{-- Optional: Show alert value on hover/title --}}
                @if ($product->quantity <= $product->quantity_alert)
                    <span class="text-xs text-red-500 block">Alert: {{ $product->quantity_alert }}</span>
                    @endif
                    @else
                    —
                    @endif
            </x-table.cell>

            {{-- 7. NEW: Inventory Status Cell --}}
            <x-table.cell>
                @if ($product->type === 'service')
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">N/A</span>
                @elseif ($product->quantity === 0)
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                @elseif ($product->quantity <= $product->quantity_alert)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Low on Stock</span>
                    @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">In
                        Stock</span>
                    @endif
            </x-table.cell>

            {{-- Actions (Edit/Delete) --}}
            <x-table.cell class="whitespace-nowrap">
                <div class="flex items-center space-x-2">

                     @include('products.partials.show')
                    {{-- Edit Button --}}
                    <a href="{{ route('products.edit', $product) }}" title="Edit"
                        class="btn">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </a>

            


                    <x-confirm-modal :action="route('products.destroy', $product->id)"
                        warning="Are you sure you want to delete this product? This action cannot be undone."
                        triggerIcon="trash-2" />


                </div>
            </x-table.cell>

        </x-table.row>
        @endforeach
        @endif

    </x-table>


</x-app-layout>