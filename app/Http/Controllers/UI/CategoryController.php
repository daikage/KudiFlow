<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('tenant_id', app('tenant_id'))->latest()->paginate(15);
        return view('inventory.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('inventory.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'tenant_id' => app('tenant_id'),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('ui.categories.index')->with('success', 'Category created.');
    }

    public function show(Category $category)
    {
        $this->authorizeCategory($category);
        return view('inventory.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);
        return view('inventory.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorizeCategory($category);
        $category->update($request->validated());
        return redirect()->route('ui.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);
        $category->delete();
        return redirect()->route('ui.categories.index')->with('success', 'Category deleted.');
    }

    protected function authorizeCategory(Category $category): void
    {
        abort_unless($category->tenant_id === app('tenant_id'), 404);
    }
}
