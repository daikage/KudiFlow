<?php

namespace App\Http\Controllers\SA;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function index()
    {
        $tenantsCount = Tenant::count();
        $usersCount = User::count();

        // Aggregates across all tenants
        $mrr = 0.00; // placeholder until you wire billing provider
        $salesToday = Sale::whereDate('created_at', today())->sum('total');
        $expensesToday = Expense::whereDate(DB::raw('COALESCE(`date`, `created_at`)'), today())->sum('amount');
        $inventoryValue = Product::selectRaw('COALESCE(SUM(stock * cost),0) as val')->value('val');

        $recentTenants = Tenant::latest()->take(8)->get(['id','name','created_at']);

        return view('sa.index', compact('tenantsCount','usersCount','mrr','salesToday','expensesToday','inventoryValue','recentTenants'));
    }

    public function tenants()
    {
        $tenants = Tenant::orderBy('name')->paginate(20, ['id','name','subdomain','created_at']);
        return view('sa.tenants.index', compact('tenants'));
    }

    public function storeTenant(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'subdomain' => ['nullable','string','max:100','unique:tenants,subdomain'],
        ]);

        Tenant::create($data);

        return back()->with('success', 'Company created.');
    }

    public function tenantDashboard(Tenant $tenant, Request $request)
    {
        // Redirect into normal UI with selected tenant context
        return redirect()->route('ui.dashboard', ['tenant_id' => $tenant->id]);
    }
}
