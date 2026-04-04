<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Services\ForecastService;
use Illuminate\Support\Facades\Cache;

class CacheForecast extends Command
{
    protected $signature = 'forecast:cache {--tenant=* : Limit to tenant IDs}';
    protected $description = 'Precompute and cache forecast data per tenant';

    public function handle(): int
    {
        $ids = collect($this->option('tenant'))->filter()->map(fn ($v) => (int) $v)->all();

        $query = Tenant::query();
        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }

        $count = 0;
        $query->chunk(100, function ($chunk) use (&$count) {
            foreach ($chunk as $tenant) {
                $data = ForecastService::forecastForTenant((int) $tenant->id);
                Cache::put("tenant:{$tenant->id}:forecast", $data, 3600);
                $this->info("Cached forecast for tenant {$tenant->id}");
                $count++;
            }
        });

        $this->info("Done. Cached {$count} tenants.");
        return self::SUCCESS;
    }
}
