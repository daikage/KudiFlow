<?php

namespace App\Http\Controllers\SA;

use App\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
    public function index()
    {
        // Wire to your billing backend later (Stripe/Paddle). For now show static view.
        return view('sa.subscriptions.index');
    }
}
