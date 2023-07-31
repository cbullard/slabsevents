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

    // public function getTopSales($id)
    // {
    //     return $this->dashboardService->getTopSales($id);
    // }

    public function getTopSales(Request $request)
    {
        return $this->dashboardService->getTopSales($request);
    }

    public function getRecentActivity(Request $request)
    {
        return $this->dashboardService->getRecentActivity($request);
    }

    public function getFollowerCount(Request $request)
    {
        return $this->dashboardService->getFollowerCount($request);
    }

    public function getTotalSales(Request $request)
    {
        return $this->dashboardService->getTotalSales($request);
    }
}
