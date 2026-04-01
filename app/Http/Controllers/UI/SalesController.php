<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () use ($request, $tenantId) {
            $product = Product::where('tenant_id', $tenantId)->findOrFail($request->product_id);

            $qty = (int) $request->qty;
            $price = (float) $product->price;
            $subtotal = $price * $qty;
            $tax = 0;
            $total = $subtotal + $tax;

            // Create sale
            $sale = Sale::create([
                'tenant_id' => $tenantId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);

            // Create item
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $price,
                'total' => $subtotal,
            ]);

            // Decrement stock
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
