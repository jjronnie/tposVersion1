<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

     public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;        
        
}

 public function index()
    {

        $user = Auth::user();


        // Fetching the core statistics (Total Products, Total Customers)
        $coreStats = $this->dashboardService->getCoreStats();
        
        // Fetching data for the dashboard components
        $topProducts = $this->dashboardService->getTopSellingProducts();
        // $topCustomers = $this->dashboardService->getTopCustomers();
        $stockAlerts = $this->dashboardService->getLowStockAlerts();

        // Merge all data and pass to the dashboard view
        $data = array_merge($coreStats, [
            'topProducts' => $topProducts,
            // 'topCustomers' => $topCustomers,
            'stockAlerts' => $stockAlerts,
        ]);

        if ($user->hasRole('superadmin')) {
            // Redirect Admins to the admin dashboard route
            return redirect()->route('superadmin.dashboard');
        }

        return view('dashboard', $data);
    }


}
