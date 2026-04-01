<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index() { return view('admin.index'); }
    public function subscriptions() { return view('admin.subscriptions.index'); }
}
