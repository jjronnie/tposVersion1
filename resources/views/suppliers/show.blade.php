<x-app-layout>
    <x-page-title title="Showing Details for Supplier: {{ $supplier->name }}" />

    <div class="p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">
            General Information
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 text-gray-700">
            
            {{-- Name --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Supplier Name</p>
                <p class="text-base font-semibold">{{ $supplier->name }}</p>
            </div>

            {{-- Status --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Status</p>
                                <x-status-badge :status="$supplier->status" />

            </div>

            {{-- Email --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Email</p>
                <p class="text-base">{{ $supplier->email ?? 'N/A' }}</p>
            </div>

            {{-- Phone --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Phone Number</p>
                <p class="text-base">{{ $supplier->phone ?? 'N/A' }}</p>
            </div>

            {{-- Contact Person --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Contact Person</p>
                <p class="text-base">{{ $supplier->contact_person ?? 'N/A' }}</p>
            </div>
            
            {{-- Tax ID --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Tax ID</p>
                <p class="text-base">{{ $supplier->tax_id ?? 'N/A' }}</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-6 border-b pb-2">
            Financial & Location
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 text-gray-700">
            {{-- Opening Balance --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Opening Balance</p>
                <p class="text-base font-mono">
                    {{-- Assuming a currency format helper or manually formatting --}}
                    $ {{ number_format($supplier->opening_balance, 2) }}
                </p>
            </div>

            {{-- Created By --}}
            <div>
                <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Created By</p>
                <p class="text-base">
                    {{ $supplier->creator ?? 'System' }}
                </p>
            </div>
        </div>
        
        {{-- Address (Full Width) --}}
        <div class="mt-8">
            <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Address</p>
            <p class="text-base mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                {{ $supplier->address ?? 'No address provided.' }}
            </p>
        </div>

        {{-- Notes (Full Width) --}}
        <div class="mt-6">
            <p class="font-medium text-sm text-gray-500 uppercase tracking-wider">Notes</p>
            <p class="text-base mt-1 p-3 bg-gray-50 rounded-md border border-gray-200 whitespace-pre-wrap">
                {{ $supplier->notes ?? 'No notes available.' }}
            </p>
        </div>
        
        <div class="mt-8 pt-4 border-t text-sm text-gray-500">
            <p>
                Created on: {{ $supplier->created_at->format('M d, Y h:i A') }} |
                Last Updated: {{ $supplier->updated_at->format('M d, Y h:i A') }}
            </p>
        </div>
        
        {{-- Action Buttons --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn bg-blue-500 hover:bg-blue-600 text-white">
                <i data-lucide="pencil" class="w-4 h-4 mr-1"></i> Edit Supplier
            </a>
            
            <a href="{{ route('suppliers.index') }}" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Back to List
            </a>
        </div>
        
    </div>
</x-app-layout>