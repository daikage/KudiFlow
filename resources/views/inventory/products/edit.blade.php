@extends('layouts.tailwind')

@section('title', 'Edit Product')
@section('search_placeholder', 'Search products...')

@section('content')
  <section class="space-y-6">
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-xl font-bold mb-4">Edit Product</h2>

      @if($errors->any())
        <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">Please fix the errors below.</div>
      @endif

      <form action="{{ route('ui.products.update', $product) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf @method('PUT')
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Product Name</label>
          <input name="name" value="{{ old('name', $product->name) }}" class="w-full bg-surface-container-low border @error('name') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
          @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">SKU</label>
          <input name="sku" value="{{ old('sku', $product->sku) }}" class="w-full bg-surface-container-low border @error('sku') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
          @error('sku')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Category</label>
          <select name="category_id" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option value="">— None —</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('category_id',$product->category_id)==$c->id)>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Status</label>
          <select name="status" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option value="active" @selected(old('status',$product->status)=='active')>Active</option>
            <option value="inactive" @selected(old('status',$product->status)=='inactive')>Inactive</option>
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Cost</label>
          <input name="cost" inputmode="decimal" value="{{ old('cost',$product->cost) }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Price</label>
          <input name="price" inputmode="decimal" value="{{ old('price',$product->price) }}" class="w-full bg-surface-container-low border @error('price') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
          @error('price')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Stock</label>
          <input name="stock" inputmode="numeric" value="{{ old('stock',$product->stock) }}" class="w-full bg-surface-container-low border @error('stock') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
          @error('stock')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Min Stock (Alert)</label>
          <input name="min_stock" inputmode="numeric" value="{{ old('min_stock',$product->min_stock) }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>

        <div class="md:col-span-2 flex gap-2 pt-2">
          <a href="{{ route('ui.products.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Update Product</button>
          <form action="{{ route('ui.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete product?')" class="inline-block">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-lg border border-error text-error hover:bg-error/5">Delete</button>
          </form>
        </div>
      </form>
    </div>
  </section>
@endsection