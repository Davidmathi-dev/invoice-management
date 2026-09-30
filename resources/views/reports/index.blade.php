@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reports</h1>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.index') }}" class="row gx-3 gy-2 align-items-center">
            <div class="col-sm-3">
                <label>From Date</label>
                <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
            </div>
            <div class="col-sm-3">
                <label>To Date</label>
                <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-4">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm"><div class="card-body">
            <h4>Sales Overview</h4>
            <table class="table">
                <tr><th>Total Sales</th><td>₹{{ number_format($reports['total_sales'], 2) }}</td></tr>
                <tr><th>Paid Sales</th><td class="text-success">₹{{ number_format($reports['paid_sales'], 2) }}</td></tr>
                <tr><th>Pending Sales</th><td class="text-warning">₹{{ number_format($reports['pending_sales'], 2) }}</td></tr>
            </table>
        </div></div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm"><div class="card-body">
            <h4>Purchases & Expenses</h4>
            <table class="table">
                <tr><th>Total Purchases</th><td>₹{{ number_format($reports['total_purchases'], 2) }}</td></tr>
                <tr><th>Total Expenses</th><td class="text-danger">₹{{ number_format($reports['total_expenses'], 2) }}</td></tr>
            </table>
        </div></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm"><div class="card-body">
            <h4>Sales By Status</h4>
            <table class="table table-bordered">
                <thead><tr><th>Status</th><th>Total Amount</th></tr></thead>
                <tbody>
                    @foreach($salesByStatus as $s)
                    <tr><td>{{ $s->status }}</td><td>₹{{ number_format($s->amount, 2) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div></div>
    </div>
</div>
@endsection