<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    public function index() { return view('support.index'); }
}
