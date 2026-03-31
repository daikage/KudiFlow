<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function summary()
    {
        // Placeholder payload for Stitch dashboard widgets
        return response()->json([
            'screen' => 'dashboard.summary',
            'totals' => [
                'today_sales' => 0,
                'this_week_sales' => 0,
                'this_month_sales' => 0,
                'expenses_today' => 0,
                'gross_profit_today' => 0,
            ],
            'status' => 'stub'
        ]);
    }
}
