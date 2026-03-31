<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(['screen' => 'products.list', 'data' => [], 'status' => 'stub']);
    }

    public function store(Request $request)
    {
        return response()->json(['screen' => 'products.create', 'status' => 'stub']);
    }

    public function show(string $id)
    {
        return response()->json(['screen' => 'products.show', 'id' => $id, 'status' => 'stub']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['screen' => 'products.update', 'id' => $id, 'status' => 'stub']);
    }

    public function destroy(string $id)
    {
        return response()->json(['screen' => 'products.delete', 'id' => $id, 'status' => 'stub']);
    }
}
