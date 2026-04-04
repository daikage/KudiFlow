<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
// NEW
use App\Services\PlanManager;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::where('tenant_id', app('tenant_id'))->latest()->paginate(20);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('tenant_id', app('tenant_id'))->where('status','active')->orderBy('name')->get();
        return view('sales.create', compact('products'));
    }

    public function store(SaleRequest $request)
    {
        $tenantId = app('tenant_id');

        // NEW: plan limit check for monthly sales count
        $limits = PlanManager::limitsForTenant((int) $tenantId);
        $salesThisMonth = Sale::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        if ($salesThisMonth >= ($limits['monthly_sales'] ?? PHP_INT_MAX)) {
            return back()
                ->withErrors(['error' => 'You have reached your monthly sales limit for your current plan. Please upgrade to record more sales.'])
                ->withInput();
        }

        DB::transaction(function () use ($request, $tenantId) {
            $product = Product::where('tenant_id', $tenantId)->lockForUpdate()->findOrFail($request->product_id);

            $qty = (int) $request->qty;

            // NEW: stock guard
            if ($product->stock < $qty) {
                abort(422, 'Insufficient stock for '.$product->name.'. Available: '.$product->stock);
            }

            $price = (float) $product->price;
            $subtotal = $price * $qty;
            $tax = 0;
            $total = $subtotal + $tax;

            $sale = Sale::create([
                'tenant_id' => $tenantId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $price,
                'total' => $subtotal,
            ]);

            $product->decrement('stock', $qty);
        });

        return redirect()->route('ui.sales.index')->with('success', 'Sale recorded.');
    }

    public function show(Sale $sale)
    {
        abort_unless($sale->tenant_id === app('tenant_id'), 404);
        $sale->load('items.product');
        return view('sales.show', compact('sale'));
    }
}
