<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tenant;

class SettingsController extends Controller
{
    public function general() { return view('settings.general'); }
    public function billing() { return view('settings.billing'); }
    public function notifications() { return view('settings.notifications'); }

    // [NEW] Update basic company settings
    public function updateGeneral(Request $request)
    {
        $tenantId = app('tenant_id');
        $tenant   = Tenant::findOrFail($tenantId);

        $data = $request->validate([
            'name'      => ['required','string','max:255'],
            'subdomain' => ['nullable','string','max:100', Rule::unique('tenants','subdomain')->ignore($tenant->id)],
        ]);

        $tenant->update($data);

        return back()->with('success', 'Settings updated.');
    }
}
