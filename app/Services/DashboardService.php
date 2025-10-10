<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getCoreStats(): array
    {


        $totalProducts = Product::count();
        $totalCustomers = Customer::count();

        return [
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ];
    }
}
