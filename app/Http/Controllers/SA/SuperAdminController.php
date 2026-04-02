<?php

namespace App\Http\Controllers\SA;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Sale;
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
        $tenants = Tenant::with('owner')->orderBy('name')->paginate(20);
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

    public function pauseTenant(Tenant $tenant, Request $request)
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:500']
        ]);

        $tenant->pause($request->reason);
        
        return back()->with('success', "Tenant {$tenant->name} has been paused.");
    }

    public function resumeTenant(Tenant $tenant)
    {
        $tenant->resume();
        
        return back()->with('success', "Tenant {$tenant->name} has been resumed.");
    }

    public function destroyTenant(Tenant $tenant)
    {
        // Optional guard: prevent deleting platform/root tenant
        if ((int) $tenant->id === 1) {
            return back()->withErrors(['error' => 'You cannot delete the root platform tenant.']);
        }

        DB::transaction(function () use ($tenant) {
            // If your FKs are set with cascadeOnDelete, this may be unnecessary.
            // This explicit cleanup helps if cascades are not configured everywhere.
            User::where('tenant_id', $tenant->id)->delete();
            Product::where('tenant_id', $tenant->id)->delete();
            Category::where('tenant_id', $tenant->id)->delete();
            Expense::where('tenant_id', $tenant->id)->delete();
            Sale::where('tenant_id', $tenant->id)->delete();

            $tenant->delete();
        });

        // Redirect appropriately depending on where the request came from
        if (request()->routeIs('admin.tenants.destroy')) {
            return redirect()->route('sa.tenants.index')->with('success', 'Company deleted.');
        }

        return back()->with('success', 'Company deleted.');
    }

    public function createTenant(Tenant $tenant)
    {
        $name = $tenant->name;
        $tenant->create();

        return back()->with('success', "Tenant {$name} has been created.");
    }
}
