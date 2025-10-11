<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('sales.index') }}" class="text-sm text-blue-600 hover:text-blue-700 inline-flex items-center mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Sales
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Sale Details</h1>
                <p class="text-sm text-gray-600 mt-1">Invoice #{{ $sale->invoice_number }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
                @if($sale->payment_status !== 'paid')
                <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Record Payment
                </button>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Sale Information Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Sale Information</h2>
                    </div>
                    <div class="px-4 sm:px-6 py-5">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Invoice Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $sale->invoice_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sale Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sale->sale_date->format('M d, Y g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ match($sale->payment_status) {
                                            'paid' => 'bg-green-100 text-green-800',
                                            'partial' => 'bg-yellow-100 text-yellow-800',
                                            'pending' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst($sale->payment_status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $sale->payment_method }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sale->creator->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sale->created_at->format('M d, Y g:i A') }}</dd>
                            </div>
                        </dl>
                        @if($sale->notes)
                        <div class="mt-4 pt-4 border-t">
                            <dt class="text-sm font-medium text-gray-500 mb-1">Notes</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $sale->notes }}</dd>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Items Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Items ({{ $sale->items->count() }})</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sale->items as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        @if($item->product)
                                        <div class="text-xs text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                        {{ number_format($item->selling_price, 0) }} UGX
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                        {{ $item->quantity }} {{ $item->unit }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">
                                        {{ number_format($item->subtotal, 0) }} UGX
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Customer</h2>
                    </div>
                    <div class="px-4 sm:px-6 py-5">
                        @if($sale->customer)
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $sale->customer->name }}</dd>
                            </div>
                            @if($sale->customer->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sale->customer->phone }}</dd>
                            </div>
                            @endif
                            @if($sale->customer->email)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sale->customer->email }}</dd>
                            </div>
                            @endif
                            <div class="pt-3">
                                <a href="{{ route('customers.show', $sale->customer) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    View Customer Details →
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Walk-in Customer</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Payment Summary</h2>
                    </div>
                    <div class="px-4 sm:px-6 py-5 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">{{ number_format($sale->subtotal, 0) }} UGX</span>
                        </div>
                        
                        @if($sale->discount_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-medium text-red-600">-{{ number_format($sale->discount_amount, 0) }} UGX</span>
                        </div>
                        @endif
                        
                        @if($sale->tax_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium text-gray-900">{{ number_format($sale->tax_amount, 0) }} UGX</span>
                        </div>
                        @endif
                        
                        <div class="pt-3 border-t">
                            <div class="flex justify-between text-base font-semibold">
                                <span class="text-gray-900">Grand Total</span>
                                <span class="text-gray-900">{{ number_format($sale->grand_total, 0) }} UGX</span>
                            </div>
                        </div>
                        
                        <div class="pt-3 border-t space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Amount Paid</span>
                                <span class="font-medium text-green-600">{{ number_format($sale->amount_paid, 0) }} UGX</span>
                            </div>
                            
                            @if($sale->balance != 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $sale->balance > 0 ? 'Change' : 'Balance Due' }}</span>
                                <span class="font-medium {{ $sale->balance > 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    {{ number_format(abs($sale->balance), 0) }} UGX
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        @if($sale->payment_status !== 'paid')
                        <div class="pt-4">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Payment {{ ucfirst($sale->payment_status) }}</h3>
                                        <p class="mt-1 text-xs text-yellow-700">
                                            Outstanding balance: {{ number_format(abs($sale->balance), 0) }} UGX
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="px-4 sm:px-6 py-5 space-y-2">
                        <button onclick="window.print()" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Receipt
                        </button>
                        <button class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Receipt
                        </button>
                        <button class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            Return/Refund
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            
            .print-area, .print-area * {
                visibility: visible;
            }
            
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            /* Hide non-print elements */
            nav, header, footer, button, .no-print {
                display: none !important;
            }
            
            /* Optimize for print */
            .bg-white {
                background-color: white !important;
            }
            
            .shadow {
                box-shadow: none !important;
            }
            
            /* Page breaks */
            .page-break {
                page-break-after: always;
            }
        }
    </style>

    <!-- Hidden Print Template -->
    <div class="hidden print-area">
        <div class="max-w-3xl mx-auto p-8">
            <!-- Receipt Header -->
            <div class="text-center mb-8 border-b-2 border-gray-800 pb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ config('app.name') }}</h1>
                <p class="text-sm text-gray-600">Sales Receipt</p>
                <p class="text-xs text-gray-500 mt-2">Invoice #{{ $sale->invoice_number }}</p>
            </div>

            <!-- Sale & Customer Info -->
            <div class="grid grid-cols-2 gap-8 mb-6 text-sm">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sale Information</h3>
                    <p class="text-gray-600">Date: {{ $sale->sale_date->format('M d, Y g:i A') }}</p>
                    <p class="text-gray-600">Payment: {{ ucfirst($sale->payment_method) }}</p>
                    <p class="text-gray-600">Served by: {{ $sale->creator->name ?? 'N/A' }}</p>
                </div>
                @if($sale->customer)
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Customer</h3>
                    <p class="text-gray-600">{{ $sale->customer->name }}</p>
                    @if($sale->customer->phone)
                    <p class="text-gray-600">{{ $sale->customer->phone }}</p>
                    @endif
                </div>
                @endif
            </div>

            <!-- Items -->
            <table class="w-full mb-6 text-sm">
                <thead>
                    <tr class="border-b-2 border-gray-800">
                        <th class="text-left py-2">#</th>
                        <th class="text-left py-2">Item</th>
                        <th class="text-right py-2">Price</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $index => $item)
                    <tr class="border-b border-gray-300">
                        <td class="py-2">{{ $index + 1 }}</td>
                        <td class="py-2">{{ $item->product_name }}</td>
                        <td class="text-right py-2">{{ number_format($item->selling_price, 0) }}</td>
                        <td class="text-center py-2">{{ $item->quantity }}</td>
                        <td class="text-right py-2 font-medium">{{ number_format($item->subtotal, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="border-t-2 border-gray-800 pt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span class="font-medium">{{ number_format($sale->subtotal, 0) }} UGX</span>
                </div>
                @if($sale->discount_amount > 0)
                <div class="flex justify-between">
                    <span>Discount:</span>
                    <span class="font-medium">-{{ number_format($sale->discount_amount, 0) }} UGX</span>
                </div>
                @endif
                @if($sale->tax_amount > 0)
                <div class="flex justify-between">
                    <span>Tax:</span>
                    <span class="font-medium">{{ number_format($sale->tax_amount, 0) }} UGX</span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold border-t border-gray-400 pt-2 mt-2">
                    <span>TOTAL:</span>
                    <span>{{ number_format($sale->grand_total, 0) }} UGX</span>
                </div>
                <div class="flex justify-between">
                    <span>Paid:</span>
                    <span class="font-medium">{{ number_format($sale->amount_paid, 0) }} UGX</span>
                </div>
                @if($sale->balance > 0)
                <div class="flex justify-between text-base font-semibold">
                    <span>Change:</span>
                    <span>{{ number_format($sale->balance, 0) }} UGX</span>
                </div>
                @elseif($sale->balance < 0)
                <div class="flex justify-between text-base font-semibold text-red-600">
                    <span>Balance Due:</span>
                    <span>{{ number_format(abs($sale->balance), 0) }} UGX</span>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 pt-6 border-t border-gray-300">
                <p class="text-sm text-gray-600">Thank you for your business!</p>
                @if($sale->notes)
                <p class="text-xs text-gray-500 mt-2">{{ $sale->notes }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-4">Printed on {{ now()->format('M d, Y g:i A') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>