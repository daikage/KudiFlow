<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return response()->json(['screen' => 'sales.list', 'data' => [], 'status' => 'stub']);
    }

    public function store(Request $request)
    {
        return response()->json(['screen' => 'sales.create', 'status' => 'stub']);
    }

    public function show(string $id)
    {
        return response()->json(['screen' => 'sales.show', 'id' => $id, 'status' => 'stub']);
    }
}
