<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

     public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;        
        
}

 public function index()
    {
        // Fetching the core statistics (Total Products, Total Customers)
        $coreStats = $this->dashboardService->getCoreStats();
        
        // Fetching data for the dashboard components
        // $topProducts = $this->dashboardService->getTopSellingProducts();
        // $topCustomers = $this->dashboardService->getTopCustomers();
        // $stockAlerts = $this->dashboardService->getLowStockAlerts();

        // Merge all data and pass to the dashboard view
        // $data = array_merge($coreStats, [
        //     'topProducts' => $topProducts,
        //     'topCustomers' => $topCustomers,
        //     'stockAlerts' => $stockAlerts,
        // ]);

        return view('dashboard', $coreStats);
    }


}
