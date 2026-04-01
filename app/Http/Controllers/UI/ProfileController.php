<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show() { return view('profile.show'); }
    public function edit() { return view('profile.edit'); }
}
