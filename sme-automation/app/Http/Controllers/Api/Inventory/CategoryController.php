<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(['screen' => 'categories.list', 'data' => [], 'status' => 'stub']);
    }

    public function store(Request $request)
    {
        return response()->json(['screen' => 'categories.create', 'status' => 'stub']);
    }

    public function show(string $id)
    {
        return response()->json(['screen' => 'categories.show', 'id' => $id, 'status' => 'stub']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['screen' => 'categories.update', 'id' => $id, 'status' => 'stub']);
    }

    public function destroy(string $id)
    {
        return response()->json(['screen' => 'categories.delete', 'id' => $id, 'status' => 'stub']);
    }
}
