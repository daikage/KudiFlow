@extends('layouts.app')

@section('title', 'Admin Overview')
@section('page-header', 'Admin Overview')

@section('content')
<div class="row g-3">
    <div class="col-md-3"><div class="card card-kpi p-3"><div class="text-muted">Tenants</div><div class="fs-4 fw-semibold">0</div></div></div>
    <div class="col-md-3"><div class="card card-kpi p-3"><div class="text-muted">Active Subscriptions</div><div class="fs-4 fw-semibold">0</div></div></div>
    <div class="col-md-3"><div class="card card-kpi p-3"><div class="text-muted">MRR</div><div class="fs-4 fw-semibold">₦0.00</div></div></div>
    <div class="col-md-3"><div class="card card-kpi p-3"><div class="text-muted">Overdue Invoices</div><div class="fs-4 fw-semibold">0</div></div></div>
</div>

<div class="card mt-3">
    <div class="card-header"><strong>Recent Tenants</strong></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Business</th><th>Owner</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody><tr><td>—</td><td>—</td><td><span class="badge bg-secondary">Inactive</span></td><td class="text-end"><a href="#" class="btn btn-sm btn-light" disabled>View</a></td></tr></tbody>
            </table>
        </div>
    </div>
</div>
@endsection
