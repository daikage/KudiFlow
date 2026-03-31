@extends('layouts.app')

@section('title', 'Create Subscription')
@section('page-header', 'Create Subscription')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="#" method="POST">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Business</label><input class="form-control" placeholder="Business name"></div>
                <div class="col-md-3"><label class="form-label">Plan</label><select class="form-select"><option>Basic</option><option>Pro</option></select></div>
                <div class="col-md-3"><label class="form-label">Status</label><select class="form-select"><option>Active</option><option>Inactive</option></select></div>
                <div class="col-md-3"><label class="form-label">Starts</label><input type="date" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Expires</label><input type="date" class="form-control"></div>
                <div class="col-12 d-flex gap-2">
                    <a href="/ui/admin/subscriptions" class="btn btn-outline-secondary">Cancel</a>
                    <button class="btn btn-primary" type="button">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
