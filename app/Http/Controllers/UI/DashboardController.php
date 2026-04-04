<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
// NEW: optional AI/baseline forecast insights
use App\Services\ForecastService;

class DashboardController extends Controller
{
    public function index()
    {
        $tenantId = app('tenant_id');
        $now      = now();
        $today    = $now->toDateString();

        // Today: sales, expenses, COGS, profit
        $salesToday    = Sale::where('tenant_id', $tenantId)->whereDate('created_at', $today)->sum('total');
        $expensesToday = Expense::where('tenant_id', $tenantId)
                            ->whereDate(DB::raw('COALESCE(`date`, `created_at`)'), $today)
                            ->sum('amount');

        $cogsToday = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.tenant_id', $tenantId)
            ->whereDate('sales.created_at', $today)
            ->selectRaw('COALESCE(SUM(sale_items.qty * products.cost), 0) as cogs')
            ->value('cogs');

        $profitToday = max($salesToday - ($cogsToday + $expensesToday), 0);

        // Delta vs same time yesterday
        $yStart = Carbon::yesterday()->startOfDay();
        $yEnd   = Carbon::yesterday()->copy()->setTimeFrom($now);
        $salesYesterdayToNow = Sale::where('tenant_id', $tenantId)->whereBetween('created_at', [$yStart, $yEnd])->sum('total');
        $cogsYesterdayToNow  = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.tenant_id', $tenantId)
            ->whereBetween('sales.created_at', [$yStart, $yEnd])
            ->selectRaw('COALESCE(SUM(sale_items.qty * products.cost), 0) as cogs')
            ->value('cogs');
        $expensesYesterday   = Expense::where('tenant_id', $tenantId)
            ->whereDate(DB::raw('COALESCE(`date`, `created_at`)'), Carbon::yesterday()->toDateString())
            ->sum('amount');

        $profitYesterdayToNow = max($salesYesterdayToNow - ($cogsYesterdayToNow + $expensesYesterday), 0);
        $deltaPercent         = $profitYesterdayToNow > 0
            ? (($profitToday - $profitYesterdayToNow) / $profitYesterdayToNow) * 100
            : ($profitToday > 0 ? 100 : 0);

        // Top sold product today
        $topProductToday = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.tenant_id', $tenantId)
            ->whereDate('sales.created_at', $today)
            ->groupBy('products.id', 'products.name')
            ->selectRaw('products.id as id, products.name as name, SUM(sale_items.qty) as units')
            ->orderByDesc('units')
            ->first();

        // Low stock alerts
        $lowStock = Product::where('tenant_id', $tenantId)
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->take(5)
            ->get(['name', 'stock']);

        // Weekly performance (last 7 days)
        $days = collect(range(0, 6))->map(fn ($i) => Carbon::today()->subDays(6 - $i));
        $weekly = $days->map(function (Carbon $d) use ($tenantId) {
            $sales    = Sale::where('tenant_id', $tenantId)->whereDate('created_at', $d->toDateString())->sum('total');
            $expenses = Expense::where('tenant_id', $tenantId)
                ->whereDate(DB::raw('COALESCE(`date`, `created_at`)'), $d->toDateString())
                ->sum('amount');
            return [
                'label'    => strtoupper($d->format('D')),
                'sales'    => (float)$sales,
                'expenses' => (float)$expenses,
            ];
        })->values();

        $weeklyMax = max(1, $weekly->pluck('sales')->max(), $weekly->pluck('expenses')->max());

        // Recent sales (10)
        $recentSales = Sale::where('tenant_id', $tenantId)
            ->latest()
            ->take(10)
            ->get(['id', 'created_at', 'total', 'payment_method', 'status']);

        // Inventory value and MTD expenses
        $inventoryValue = Product::where('tenant_id', $tenantId)
            ->selectRaw('COALESCE(SUM(stock * cost),0) as val')
            ->value('val');

        $expensesMTD = Expense::where('tenant_id', $tenantId)
            ->whereBetween(DB::raw('COALESCE(`date`, `created_at`)'), [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        // NEW: Smart Insights
        $hasSales = Sale::where('tenant_id', $tenantId)->exists();
        $insights = [];

        if ($hasSales) {
            // Fastest seller in last 7 days
            $since7 = Carbon::today()->subDays(6)->toDateString();
            $fastSeller7d = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->where('sales.tenant_id', $tenantId)
                ->whereDate('sales.created_at', '>=', $since7)
                ->groupBy('products.id', 'products.name')
                ->selectRaw('products.name as name, SUM(sale_items.qty) as units')
                ->orderByDesc('units')
                ->first();

            if ($fastSeller7d) {
                $insights[] = "Fastest seller (7d): {$fastSeller7d->name} ({$fastSeller7d->units} units)";
            }

            // Slow movers: stock > 0 and no sales in last 30 days
            $since30 = Carbon::today()->subDays(29)->toDateString();
            $soldProductIds = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sales.tenant_id', $tenantId)
                ->whereDate('sales.created_at', '>=', $since30)
                ->pluck('sale_items.product_id')
                ->unique()
                ->all();

            $slowMovers = Product::where('tenant_id', $tenantId)
                ->where('stock', '>', 0)
                ->when(!empty($soldProductIds), fn($q) => $q->whereNotIn('id', $soldProductIds))
                ->orderByDesc('stock')
                ->take(3)
                ->get(['name','stock']);

            if ($slowMovers->isNotEmpty()) {
                $list = $slowMovers->map(fn($p) => "{$p->name} (stock {$p->stock})")->implode(', ');
                $insights[] = "Slow movers (30d): ".$list;
            }

            // Reorder suggestions (reuse lowStock list)
            if ($lowStock->isNotEmpty()) {
                $list = $lowStock->map(fn($p) => "{$p->name} (stock {$p->stock})")->implode(', ');
                $insights[] = "Reorder suggested: ".$list;
            }

            // Optional AI/baseline price movement highlight (uses ForecastService)
            try {
                $f = ForecastService::forecastForTenant((int) $tenantId);
                $rising = collect($f['products'] ?? [])
                    ->filter(fn($p) => $p['price_now'] !== null && $p['price_30d'] !== null && $p['price_30d'] > $p['price_now'] * 1.05)
                    ->sortByDesc(fn($p) => $p['price_30d'] - $p['price_now'])
                    ->take(1)
                    ->first();

                if ($rising) {
                    $delta = round($rising['price_30d'] - $rising['price_now'], 2);
                    $insights[] = "Projected price rise: {$rising['name']} +₦{$delta} in 30 days.";
                }
            } catch (\Throwable $e) {
                // ignore forecasting errors
            }
        }

        return view('dashboard.index', [
            'profitToday'     => $profitToday,
            'deltaPercent'    => $deltaPercent,
            'salesToday'      => $salesToday,
            'expensesToday'   => $expensesToday,
            'topProductToday' => $topProductToday,
            'lowStock'        => $lowStock,
            'weekly'          => $weekly,
            'weeklyMax'       => $weeklyMax,
            'recentSales'     => $recentSales,
            'inventoryValue'  => $inventoryValue,
            'expensesMTD'     => $expensesMTD,
            // NEW
            'hasSales'        => $hasSales,
            'insights'        => $insights,
        ]);
    }
}
