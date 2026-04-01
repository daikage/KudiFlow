<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function general() { return view('settings.general'); }
    public function billing() { return view('settings.billing'); }
    public function notifications() { return view('settings.notifications'); }
}
