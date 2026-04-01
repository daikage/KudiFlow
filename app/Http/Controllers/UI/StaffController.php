<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    public function index()  { return view('staff.index'); }
    public function create() { return view('staff.create'); }
    public function show($id) { return view('staff.show', compact('id')); }
    public function edit($id) { return view('staff.edit', compact('id')); }
}
