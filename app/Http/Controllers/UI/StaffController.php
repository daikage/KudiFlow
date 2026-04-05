<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $tenantId = (int) app('tenant_id');
        $staff = User::query()
            ->where('tenant_id', $tenantId)
            ->where('super_admin', false)
            ->orderBy('name')
            ->get();

        return view('staff.index', compact('staff'));
    }

    public function create() { return view('staff.create'); }
    public function show($id) { return view('staff.show', compact('id')); }
    public function edit($id)
    {
        $tenantId = (int) app('tenant_id');
        $staff = User::query()
            ->where('tenant_id', $tenantId)
            ->where('super_admin', false)
            ->findOrFail($id);
        return view('staff.edit', compact('staff'));
    }

    public function store(Request $request)
    {
        $tenantId = (int) app('tenant_id');
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'  => ['required', 'in:staff,manager,admin'],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        $plainPassword = $data['password'] ?? \Illuminate\Support\Str::random(12);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'tenant_id' => $tenantId,
            'role' => $data['role'],
            'password' => $plainPassword, // auto-hashed by casts
        ]);

        return redirect()
            ->route('ui.staff.index')
            ->with('success', 'Staff added successfully.')
            ->with('new_staff', [
                'email' => $data['email'],
                'password' => $plainPassword,
            ]);
    }

    public function update(Request $request, $id)
    {
        $tenantId = (int) app('tenant_id');
        $staff = User::query()
            ->where('tenant_id', $tenantId)
            ->where('super_admin', false)
            ->findOrFail($id);

        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($staff->id)],
            'role'  => ['required','in:staff,manager,admin'],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        $staff->name = $data['name'];
        $staff->email = $data['email'];
        $staff->role = $data['role'];

        $updatedCredentials = null;
        if (!empty($data['password'])) {
            $staff->password = $data['password']; // auto-hashed by casts
            $updatedCredentials = [
                'email' => $staff->email,
                'password' => $data['password'],
            ];
        }

        $staff->save();

        $redirect = redirect()
            ->route('ui.staff.edit', $staff->id)
            ->with('success', 'Staff updated successfully.');

        if ($updatedCredentials) {
            $redirect->with('updated_staff', $updatedCredentials);
        }

        return $redirect;
    }
}
