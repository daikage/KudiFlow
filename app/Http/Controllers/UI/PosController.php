<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = (int) app('tenant_id');
        $cart = CartService::get($tenantId);

        return view('pos.index', compact('cart'));
    }

    // Scan by barcode or SKU, returns JSON product info
    public function scan(Request $request)
    {
        $data = $request->validate([
            'code' => ['required','string','max:128'], // barcode or SKU
        ]);

        $tenantId = (int) app('tenant_id');

        $product = Product::where('tenant_id', $tenantId)
            ->where('status', 'active')
            ->where(function ($q) use ($data) {
                // Try barcode first if present, fallback to SKU
                $q->where('barcode', $data['code'])
                  ->orWhere('sku', $data['code']);
            })
            ->first();

        if (! $product) {
            return response()->json(['ok' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'ok' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'price' => (float) $product->price,
                'stock' => (int) $product->stock,
            ],
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['nullable','integer','min:1'],
        ]);

        $tenantId = (int) app('tenant_id');

        $product = Product::where('tenant_id', $tenantId)
            ->where('status','active')
            ->findOrFail($data['product_id']);

        $qty = (int) ($data['qty'] ?? 1);

        $cart = CartService::add($tenantId, $product, $qty);

        return response()->json(['ok' => true, 'cart' => $cart]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer'],
            'qty' => ['required','integer','min:1'],
        ]);

        $tenantId = (int) app('tenant_id');
        $cart = CartService::updateQty($tenantId, (int) $data['product_id'], (int) $data['qty']);

        return response()->json(['ok' => true, 'cart' => $cart]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer'],
        ]);

        $tenantId = (int) app('tenant_id');
        $cart = CartService::remove($tenantId, (int) $data['product_id']);

        return response()->json(['ok' => true, 'cart' => $cart]);
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['nullable','string','max:50'],
        ]);

        $tenantId = (int) app('tenant_id');
        $cart = CartService::get($tenantId);

        if (empty($cart['items'])) {
            return response()->json(['ok' => false, 'message' => 'Cart is empty'], 422);
        }

        // Create sale transaction with stock guard
        DB::transaction(function () use ($tenantId, $cart, $data) {
            // Lock all products rows we’re going to modify
            $productIds = array_keys($cart['items']);
            $products = Product::where('tenant_id', $tenantId)
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Validate stock
            foreach ($cart['items'] as $pid => $item) {
                $p = $products[$pid] ?? null;
                if (! $p) {
                    abort(422, 'Product missing during checkout.');
                }
                if ($p->stock < $item['qty']) {
                    abort(422, 'Insufficient stock for '.$p->name.'. Available: '.$p->stock);
                }
            }

            // Totals
            $subtotal = (float) collect($cart['items'])->sum(fn ($i) => $i['price'] * $i['qty']);
            $tax = 0.0;
            $total = $subtotal + $tax;

            $sale = Sale::create([
                'tenant_id' => $tenantId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $data['payment_method'] ?? null,
                'status' => 'completed',
            ]);

            foreach ($cart['items'] as $pid => $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $pid,
                    'qty' => (int) $item['qty'],
                    'price' => (float) $item['price'],
                    'total' => (float) $item['price'] * (int) $item['qty'],
                ]);

                // decrement stock
                $products[$pid]->decrement('stock', (int) $item['qty']);
            }

            // Clear cart on success
            CartService::clear($tenantId);
        });

        return response()->json(['ok' => true, 'message' => 'Sale completed.']);
    }

    // NEW: scan and add in one request (better UX for mobile scanner and Add button)
    public function scanAdd(Request $request)
    {
        $data = $request->validate([
            'code' => ['required','string','max:128'],
            'qty'  => ['nullable','integer','min:1'],
        ]);

        $tenantId = (int) app('tenant_id');

        $product = Product::where('tenant_id', $tenantId)
            ->where('status', 'active')
            ->where(function ($q) use ($data) {
                $q->where('barcode', $data['code'])
                  ->orWhere('sku', $data['code']);
            })
            ->first();

        if (! $product) {
            return response()->json(['ok' => false, 'message' => 'Product not found'], 404);
        }

        $qty = (int) ($data['qty'] ?? 1);
        $cart = CartService::add($tenantId, $product, $qty);

        return response()->json(['ok' => true, 'cart' => $cart]);
    }
}
