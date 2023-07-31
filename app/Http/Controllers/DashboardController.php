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

    public function getTopSales($id)
    {
        return $this->dashboardService->getTopSales($id);
    }

    public function getRecentActivity($id, $offset, $limit)
    {
        return $this->dashboardService->getRecentActivity($id, $offset, $limit);
    }

    public function getFollowerCount($id)
    {
        return $this->dashboardService->getFollowerCount($id);
    }

    public function getTotalSales($id)
    {
        return $this->dashboardService->getTotalSales($id);
    }
}
