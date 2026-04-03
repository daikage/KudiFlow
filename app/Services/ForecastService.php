<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Contracts\ForecastProvider;

class ForecastService
{
    /**
     * Build forecasts for a tenant and optionally overlay AI predictions.
     */
    public static function forecastForTenant(int $tenantId): array
    {
        $daysBack = 30;
        $start = Carbon::today()->subDays($daysBack - 1);
        $dates = collect(range(0, $daysBack - 1))
            ->map(fn ($i) => $start->copy()->addDays($i)->toDateString());

        $revenueByDay = DB::table('sales')
            ->where('tenant_id', $tenantId)
            ->whereDate('created_at', '>=', $start->toDateString())
            ->selectRaw('DATE(created_at) as d, SUM(total) as revenue')
            ->groupBy('d')
            ->pluck('revenue', 'd');

        $cogsByDay = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.tenant_id', $tenantId)
            ->whereDate('sales.created_at', '>=', $start->toDateString())
            ->selectRaw('DATE(sales.created_at) as d, COALESCE(SUM(sale_items.qty * products.cost), 0) as cogs')
            ->groupBy('d')
            ->pluck('cogs', 'd');

        $expensesByDay = DB::table('expenses')
            ->where('tenant_id', $tenantId)
            ->whereDate(DB::raw('COALESCE(`date`, `created_at`)'), '>=', $start->toDateString())
            ->selectRaw('DATE(COALESCE(`date`, `created_at`)) as d, SUM(amount) as expenses')
            ->groupBy('d')
            ->pluck('expenses', 'd');

        $profitSeries = $dates->map(function ($d) use ($revenueByDay, $cogsByDay, $expensesByDay) {
            $rev = (float) ($revenueByDay[$d] ?? 0);
            $cogs = (float) ($cogsByDay[$d] ?? 0);
            $exp = (float) ($expensesByDay[$d] ?? 0);
            return [
                'date' => $d,
                'profit' => max($rev - $cogs - $exp, 0),
            ];
        })->values();

        $profitValues = $profitSeries->pluck('profit')->all();
        $trend = self::linearTrend($profitValues);
        $lastY = end($profitValues) ?: 0;
        $forecastNext7 = collect(range(1, 7))->map(fn ($i) => max($trend['a'] + $trend['b'] * (count($profitValues) - 1 + $i), 0));
        $profitNext7Sum = (float) $forecastNext7->sum();

        $profitToday = (float) ($profitSeries->last()['profit'] ?? 0);
        $profit7dAvg = (float) collect(array_slice($profitValues, -7))->avg() ?: 0;

        $salesByProductDay = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.tenant_id', $tenantId)
            ->whereDate('sales.created_at', '>=', $start->toDateString())
            ->selectRaw('sale_items.product_id, DATE(sales.created_at) as d, SUM(sale_items.qty) as units, AVG(sale_items.price) as avg_price')
            ->groupBy('sale_items.product_id', 'd')
            ->get()
            ->groupBy('product_id');

        $products = DB::table('products')
            ->where('tenant_id', $tenantId)
            ->select('id', 'name', 'stock', 'cost')
            ->get()
            ->keyBy('id');

        $perProducts = [];
        foreach ($products as $prod) {
            $series = $salesByProductDay->get($prod->id, collect());
            $dailyUnits = $dates->map(fn ($d) => (int) optional($series->firstWhere('d', $d))->units);
            $avgDaily = (float) collect($dailyUnits->take($daysBack)->all())->avg() ?: 0.0;

            $daysToDeplete = null;
            if ($avgDaily > 0.0001) {
                $daysToDeplete = (int) ceil($prod->stock / $avgDaily);
            }

            $priceSeries = $dates->map(fn ($d) => (float) optional($series->firstWhere('d', $d))->avg_price)->filter(fn ($v) => $v > 0);
            $priceValues = array_values($priceSeries->all());
            $priceTrend = self::linearTrend($priceValues);
            $lastPrice = end($priceValues) ?: null;
            $price30dForecast = $lastPrice !== null ? max($priceTrend['a'] + $priceTrend['b'] * (count($priceValues) - 1 + 30), 0) : null;

            $perProducts[] = [
                'id'               => $prod->id,
                'name'             => $prod->name,
                'stock'            => (int) $prod->stock,
                'avg_daily_units'  => round($avgDaily, 2),
                'days_to_deplete'  => $daysToDeplete,
                'price_now'        => $lastPrice !== null ? round($lastPrice, 2) : null,
                'price_30d'        => $price30dForecast !== null ? round($price30dForecast, 2) : null,
            ];
        }

        // Baseline result
        $result = [
            'overall' => [
                'profit_today'       => round($profitToday, 2),
                'profit_7d_avg'      => round($profit7dAvg, 2),
                'profit_next_7d_sum' => round($profitNext7Sum, 2),
                'profit_series'      => $profitSeries,
            ],
            'products' => $perProducts,
        ];

        // Attempt AI overlay
        $driver = config('ai.forecast.driver', 'baseline');
        if ($driver === 'openai' && config('ai.forecast.openai.api_key')) {
            try {
                $provider = app(ForecastProvider::class);
                $overlay  = $provider->forecast($result);

                // Overlay overall
                $aiOverall = $overlay['overall'] ?? [];
                if (isset($aiOverall['profit_next_7d_sum'])) {
                    $result['overall']['profit_next_7d_sum'] = round((float) $aiOverall['profit_next_7d_sum'], 2);
                }

                // Overlay per product by id
                $byId = collect($result['products'])->keyBy('id');
                foreach ($overlay['products'] ?? [] as $p) {
                    $id = (int) ($p['id'] ?? 0);
                    if ($byId->has($id)) {
                        $row = $byId->get($id);
                        if (array_key_exists('days_to_deplete', $p)) {
                            $row['days_to_deplete'] = $p['days_to_deplete'];
                        }
                        if (array_key_exists('price_30d', $p)) {
                            $row['price_30d'] = $p['price_30d'] !== null ? round((float) $p['price_30d'], 2) : null;
                        }
                        $byId[$id] = $row;
                    }
                }
                $result['products'] = $byId->values()->all();

                $result['ai'] = [
                    'used'  => true,
                    'model' => config('ai.forecast.openai.model'),
                ];
            } catch (\Throwable $e) {
                $result['ai'] = ['used' => false];
            }
        } else {
            $result['ai'] = ['used' => false];
        }

        return $result;
    }

    protected static function linearTrend(array $y): array
    {
        $n = count($y);
        if ($n === 0) return ['a' => 0.0, 'b' => 0.0];
        if ($n === 1) return ['a' => (float) $y[0], 'b' => 0.0];

        $x = range(0, $n - 1);
        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXY = 0.0;
        $sumXX = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $y[$i];
            $sumXX += $x[$i] * $x[$i];
        }
        $den = ($n * $sumXX - $sumX * $sumX);
        $b = $den != 0 ? ($n * $sumXY - $sumX * $sumY) / $den : 0.0;
        $a = ($sumY - $b * $sumX) / $n;

        return ['a' => (float) $a, 'b' => (float) $b];
    }
}
