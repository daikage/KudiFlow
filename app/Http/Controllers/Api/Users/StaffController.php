<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return response()->json(['screen' => 'staff.list', 'data' => [], 'status' => 'stub']);
    }

    public function store(Request $request)
    {
        return response()->json(['screen' => 'staff.create', 'status' => 'stub']);
    }

    public function show(string $id)
    {
        return response()->json(['screen' => 'staff.show', 'id' => $id, 'status' => 'stub']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['screen' => 'staff.update', 'id' => $id, 'status' => 'stub']);
    }

    public function destroy(string $id)
    {
        return response()->json(['screen' => 'staff.delete', 'id' => $id, 'status' => 'stub']);
    }
}
