<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get total counts for key stats.
     */
    public function getCoreStats(): array
    {
        $businessId = auth()->user()->business_id;

        $totalProducts = Product::where('is_active', true)
            ->where('business_id', $businessId)
            ->count();

        $totalCustomers = Customer::where('status', 'enabled')
            ->where('business_id', $businessId)
            ->count();

        return [
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ];
    }

    /**
     * Get top selling products.
     */
    public function getTopSellingProducts(int $limit = 10): array
    {
        $businessId = auth()->user()->business_id;

        return Product::select('products.id', 'products.name', 'products.unit')
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->selectRaw('SUM(sale_items.quantity) as total_sold')
            ->where('products.is_active', true)
            ->where('products.business_id', $businessId)
            ->groupBy('products.id', 'products.name', 'products.unit')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get top customers by total spent.
     */
//    public function getTopCustomers(int $limit = 10): array
// {
//     return Customer::select(
//             'customers.id',
//             'customers.name',
//             'customers.email',
//             'customers.avatar'
//         )
//         ->join('sales', 'customers.id', '=', 'sales.customer_id')
//         ->selectRaw('COUNT(sales.id) as total_purchases')
//         ->selectRaw('SUM(sales.grand_total) as total_spent')
//         ->where('customers.status', 'enabled')
//         ->whereColumn('customers.business_id', 'sales.business_id') // ensures both sides match tenant
//         ->groupBy('customers.id', 'customers.name', 'customers.email', 'customers.avatar')
//         ->orderByDesc('total_spent')
//         ->limit($limit)
//         ->get()
//         ->toArray();
// }


    /**
     * Get low stock product alerts.
     */
    public function getLowStockAlerts(int $threshold = 10): array
    {
        $businessId = auth()->user()->business_id;

        return Product::select('id', 'name', 'quantity', 'quantity_alert', 'avatar')
            ->where('is_active', true)
            ->where('business_id', $businessId)
            ->where(function ($query) use ($threshold) {
                $query->whereColumn('quantity', '<=', 'quantity_alert')
                      ->orWhere('quantity', '<=', $threshold);
            })
            ->orderBy('quantity', 'asc')
            ->get()
            ->toArray();
    }
}
