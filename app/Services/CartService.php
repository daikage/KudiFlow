<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;

class CartService
{
    protected static function key(int $tenantId): string
    {
        return "tenant:{$tenantId}:pos_cart";
    }

    public static function get(int $tenantId): array
    {
        return session(self::key($tenantId), [
            'items' => [],    // [product_id => ['id','name','sku','barcode','price','qty','stock']]
            'subtotal' => 0.0,
            'tax' => 0.0,
            'total' => 0.0,
        ]);
    }

    protected static function recalc(array &$cart): void
    {
        $cart['subtotal'] = collect($cart['items'])->sum(fn ($i) => $i['price'] * $i['qty']);
        $cart['tax'] = 0.0; // extend later if needed
        $cart['total'] = $cart['subtotal'] + $cart['tax'];
    }

    public static function put(int $tenantId, array $cart): void
    {
        session([self::key($tenantId) => $cart]);
    }

    public static function clear(int $tenantId): void
    {
        session()->forget(self::key($tenantId));
    }

    public static function add(int $tenantId, Product $product, int $qty): array
    {
        $cart = self::get($tenantId);

        $item = $cart['items'][$product->id] ?? [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode ?? null,
            'price' => (float) $product->price,
            'qty' => 0,
            'stock' => (int) $product->stock,
        ];

        $item['qty'] += $qty;
        // do not let cart qty exceed current stock (soft guard; final guard is at checkout)
        $item['qty'] = min($item['qty'], (int) $product->stock);

        $cart['items'][$product->id] = $item;
        self::recalc($cart);
        self::put($tenantId, $cart);

        return $cart;
    }

    public static function updateQty(int $tenantId, int $productId, int $qty): array
    {
        $cart = self::get($tenantId);
        if (! isset($cart['items'][$productId])) {
            return $cart;
        }
        $item = $cart['items'][$productId];
        $item['qty'] = max(1, $qty);
        $cart['items'][$productId] = $item;
        self::recalc($cart);
        self::put($tenantId, $cart);
        return $cart;
    }

    public static function remove(int $tenantId, int $productId): array
    {
        $cart = self::get($tenantId);
        unset($cart['items'][$productId]);
        self::recalc($cart);
        self::put($tenantId, $cart);
        return $cart;
    }
}

