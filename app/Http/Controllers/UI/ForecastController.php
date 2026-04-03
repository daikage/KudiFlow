<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Services\ForecastService;

class ForecastController extends Controller
{
    public function index()
    {
        $tenantId = (int) app('tenant_id');
        $data = ForecastService::forecastForTenant($tenantId);

        return view('forecast.index', [
            'overall'  => $data['overall'],
            'products' => $data['products'],
        ]);
    }
}

