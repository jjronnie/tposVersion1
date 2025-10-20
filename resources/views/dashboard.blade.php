<x-app-layout>

<x-page-title />


<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
<!-- card -->
 <x-stat-card title="Total Sales" value=" {{ business_currency() }}" icon="shopping-cart" />
<x-stat-card title="Total Expenses" value="0" icon="receipt" />
<x-stat-card title="Total Products" value="{{ $total_products ?? '-'}}" icon="package" />
<x-stat-card title="Total Customers" value="{{ $total_customers ?? '-' }}" icon="users" />
<x-stat-card title="Total Customers" value="{{ $total_customers ?? '-' }}" icon="users" />
<x-stat-card title="Total Customers" value="{{ $total_customers ?? '-' }}" icon="users" />
<x-stat-card title="Total Customers" value="{{ $total_customers ?? '-' }}" icon="users" />
<x-stat-card title="Total Customers" value="{{ $total_customers ?? '-' }}" icon="users" />
</div>



<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

   <div class="bg-white rounded-xl p-6 h-full">
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
                       
                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                        <span class=" text-sm font-medium text-gray-700">{{ $product['name'] }}</span>
                    </div>
                    <span class="font-semibold text-gray-900 text-sm ml-3 flex-shrink-0">
                      Sold  {{ number_format($product['total_sold']) }}   {{ ucfirst($product['unit']) }} 
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state message="No products data yet." />
    @endif
</div>

        <div class="bg-white  rounded-xl p-6 h-full">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i data-lucide="users" class="w-5 h-5 mr-2 text-green-500"></i>
                    Top Customers
                </h3>
                <a href="#" class="text-sm text-green-600 hover:text-green-800">View All</a>
            </div>
            
            <ul class="divide-y divide-gray-100">
                @for ($i = 1; $i <= 5; $i++)
                    <li class="py-2 flex items-center justify-between text-sm">
                        <span class="truncate pr-2">Customer Name {{ $i }}</span>
                        <span class="font-semibold text-gray-900">$ {{ number_format(rand(1000, 5000), 2) }}</span>
                    </li>
                @endfor
            </ul>
            @if (false) 
                <p class="text-gray-500 mt-4">No customer data available yet.</p>
            @endif
        </div>

        <div class="bg-white  rounded-xl p-6 hidden lg:block h-full">
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
    
    <div class="bg-white  rounded-xl p-6 overflow-hidden">
        <div class="flex items-center justify-between border-b pb-3 mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i data-lucide="alert-triangle" class="w-5 h-5 mr-2 text-red-500"></i>
                Low Stock Alerts
            </h3>
            <a href="#" class="text-sm text-red-600 hover:text-red-800">Manage Stock</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Threshold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3"></th> {{-- Action column --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for ($i = 1; $i <= 4; $i++)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Product X-00{{ $i }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SKU{{ rand(100, 999) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-red-600">
                                {{ rand(1, 10) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Global Supplies Inc.
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">Order</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        @if (false) 
            <p class="text-gray-500 mt-4">All stock levels are healthy.</p>
        @endif
    </div>

</div>





</x-app-layout>
