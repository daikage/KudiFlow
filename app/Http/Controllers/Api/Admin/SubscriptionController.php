<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return response()->json(['screen' => 'admin.subscriptions.list', 'data' => [], 'status' => 'stub']);
    }

    public function store(Request $request)
    {
        return response()->json(['screen' => 'admin.subscriptions.create', 'status' => 'stub']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['screen' => 'admin.subscriptions.update', 'id' => $id, 'status' => 'stub']);
    }

    public function destroy(string $id)
    {
        return response()->json(['screen' => 'admin.subscriptions.delete', 'id' => $id, 'status' => 'stub']);
    }
}
