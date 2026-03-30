<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function overview()
    {
        return response()->json([
            'screen' => 'admin.overview',
            'widgets' => [
                'tenants' => 0,
                'active_subscriptions' => 0,
                'monthly_recurring_revenue' => 0,
                'overdue_invoices' => 0,
            ],
            'status' => 'stub'
        ]);
    }
}
