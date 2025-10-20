<x-app-layout>

    <x-page-title />


    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
        <!-- card -->
        <x-stat-card title="Total Sales" value="{{ business_currency() }} {{ $total_sales_amount ?? '-'}} " icon="shopping-cart" />
        <x-stat-card title="Total Expenses" value="0" icon="receipt" />
        <x-stat-card title="Total Products" value="{{ $total_products ?? '-'}}" icon="package" />
        <x-stat-card title="Total Customers" value="{{ $total_customers ?? '-' }}" icon="users" />
      
    </div>



    <div class="space-y-6">

        <div id="dashboard-widgets" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="dashboard-card bg-white rounded-xl p-6 h-full" data-id="top-products">
                <div class="flex items-center justify-between border-b pb-3 mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 mr-2 text-indigo-500"></i>
                        Top Selling Products
                    </h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                </div>

                @if(count($topProducts) > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach ($topProducts as $product)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">

                            <div
                                class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <span class=" text-sm font-medium text-gray-700">{{ $product['name'] }}</span>
                        </div>
                        <span class="font-semibold text-gray-900 text-sm ml-3 flex-shrink-0">
                            Sold {{ number_format($product['total_sold']) }} {{ ucfirst($product['unit']) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @else
                <x-empty-state message="No products data yet." />
                @endif
            </div>

            <div class="dashboard-card bg-white  rounded-xl p-6 h-full" data-id="top-customers">
                <div class="flex items-center justify-between border-b pb-3 mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i data-lucide="users" class="w-5 h-5 mr-2 text-green-500"></i>
                        Top Customers
                    </h3>
                    <a href="#" class="text-sm text-green-600 hover:text-green-800">View All</a>
                </div>

                <ul class="divide-y divide-gray-100">
                    @for ($i = 1; $i <= 5; $i++) <li class="py-2 flex items-center justify-between text-sm">
                        <span class="truncate pr-2">Customer Name {{ $i }}</span>
                        <span class="font-semibold text-gray-900">$ {{ number_format(rand(1000, 5000), 2) }}</span>
                        </li>
                        @endfor
                </ul>
                @if (false)
                <p class="text-gray-500 mt-4">No customer data available yet.</p>
                @endif
            </div>

            <div class="dashboard-card bg-white  rounded-xl p-6 hidden lg:block h-full " data-id="revenue">
                <div class="flex items-center justify-between border-b pb-3 mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i data-lucide="line-chart" class="w-5 h-5 mr-2 text-yellow-500"></i>
                        Revenue
                    </h3>
                    <span class="text-sm text-yellow-600 font-medium">This Month</span>
                </div>
                <p class="text-4xl font-bold text-gray-900 mt-4">$ {{ number_format(15234.55, 2) }}</p>
                <p class="text-sm text-green-500 mt-2">▲ 12% increase from last month</p>
            </div>

        </div>

        <div class="bg-white rounded-xl p-6 overflow-hidden">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5 mr-2 text-red-500"></i>
                    Low Stock Alerts
                </h3>
                <a href="{{ route('products.index') }}" class="text-sm text-red-600 hover:text-red-800">Manage Stock</a>
            </div>

            @if(count($stockAlerts) > 0)
            <x-table :headers="['Product', 'Current Stock', 'Alert Level', 'Status', 'Actions']" >

                @foreach ($stockAlerts as $product)
                <x-table.row>
                    <x-table.cell>
                        <div class="flex items-center">
                            @if($product['avatar'])
                            <img src="{{ asset('storage/' . $product['avatar']) }}" alt="{{ $product['name'] }}"
                                class="w-10 h-10 rounded-lg object-cover mr-3">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                                <i data-lucide="package" class="w-5 h-5 text-red-600"></i>
                            </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $product['name'] }}</div>
                            </div>
                        </div>
                    </x-table.cell>

                    <x-table.cell class="text-center">
                        <span
                            class="text-sm font-bold {{ $product['quantity'] == 0 ? 'text-red-700' : 'text-red-600' }}">
                            {{ number_format($product['quantity']) }}
                        </span>
                    </x-table.cell>

                    <x-table.cell class="text-center text-sm text-gray-500">
                        {{ number_format($product['quantity_alert']) }}
                    </x-table.cell>

                    <x-table.cell class="text-center">
                        @if($product['quantity'] == 0)
                        <span
                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Out of Stock
                        </span>
                        @elseif($product['quantity'] <= $product['quantity_alert'] / 2) <span
                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Critical
                            </span>
                            @else
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Low Stock
                            </span>
                            @endif
                    </x-table.cell>

                    <x-table.cell class="text-right text-sm font-medium">
                        <a href="{{ route('products.show', $product['id']) }}"
                            class="btn">
                            View
                        </a>
                    </x-table.cell>
                </x-table.row>
                @endforeach
            </x-table>

            @else
            <div class="text-center py-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                    <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
                </div>
                <p class="text-gray-500 text-sm">All stock levels are healthy.</p>
            </div>
            @endif
        </div>


    </div>





</x-app-layout>