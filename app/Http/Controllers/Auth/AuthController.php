<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('ui.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
            'remember' => ['nullable','boolean'],
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('ui.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials provided.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('ui.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', \Illuminate\Validation\Rule::unique('users','email')],
            'password' => ['required','string','min:8','confirmed'],
            'store_name' => ['nullable','string','max:255'],
        ]);

        // Create a new tenant per registration (company onboarding)
        $tenant = \App\Models\Tenant::create([
            'name' => $data['store_name'] ?: ($data['name']."'s Company"),
        ]);

        // Create owner as admin of their company
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        // Create default trial subscription (5 days)
        Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'trial',
            'status' => 'trial',
            'modules' => Subscription::defaultModules(),
            'starts_at' => now(),
            'trial_ends_at' => now()->addDays(5),
            'ends_at' => null,
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        // Redirect to subscription (billing) page first
        return redirect()->route('ui.settings.billing')->with('success', 'Welcome! Your 5-day trial has started.');
    }
}
