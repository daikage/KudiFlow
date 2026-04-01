<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = app('tenant_id');

        $products = Product::with('category')
            ->where('tenant_id', $tenantId)
            ->when($request->q, fn($q) => $q->where(fn($qq) =>
                $qq->where('name', 'like', '%'.$request->q.'%')
                   ->orWhere('sku', 'like', '%'.$request->q.'%')))
            ->latest()
            ->paginate(12);

        return view('inventory.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('tenant_id', app('tenant_id'))->orderBy('name')->get();
        return view('inventory.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['tenant_id'] = app('tenant_id');
        Product::create($data);

        return redirect()->route('ui.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        $this->authorizeProduct($product);
        return view('inventory.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        $categories = Category::where('tenant_id', app('tenant_id'))->orderBy('name')->get();
        return view('inventory.products.edit', compact('product','categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorizeProduct($product);
        $product->update($request->validated());
        return redirect()->route('ui.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()->route('ui.products.index')->with('success', 'Product deleted.');
    }

    protected function authorizeProduct(Product $product): void
    {
        abort_unless($product->tenant_id === app('tenant_id'), 404);
    }
}
