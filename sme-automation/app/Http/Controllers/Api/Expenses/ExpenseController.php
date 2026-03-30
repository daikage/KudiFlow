<?php

namespace App\Http\Controllers\Api\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return response()->json(['screen' => 'expenses.list', 'data' => [], 'status' => 'stub']);
    }

    public function store(Request $request)
    {
        return response()->json(['screen' => 'expenses.create', 'status' => 'stub']);
    }

    public function show(string $id)
    {
        return response()->json(['screen' => 'expenses.show', 'id' => $id, 'status' => 'stub']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['screen' => 'expenses.update', 'id' => $id, 'status' => 'stub']);
    }

    public function destroy(string $id)
    {
        return response()->json(['screen' => 'expenses.delete', 'id' => $id, 'status' => 'stub']);
    }
}
