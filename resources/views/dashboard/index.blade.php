@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3"><div class="card bg-primary text-white"><div class="card-body"><h5>Customers</h5><h3>{{ $counts['customers'] }}</h3></div></div></div>
    <div class="col-md-3 mb-3"><div class="card bg-success text-white"><div class="card-body"><h5>Suppliers</h5><h3>{{ $counts['suppliers'] }}</h3></div></div></div>
    <div class="col-md-3 mb-3"><div class="card bg-info text-white"><div class="card-body"><h5>Products</h5><h3>{{ $counts['products'] }}</h3></div></div></div>
    <div class="col-md-3 mb-3"><div class="card bg-warning text-white"><div class="card-body"><h5>Sales Invoices</h5><h3>{{ $counts['sales_invoices'] }}</h3></div></div></div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3"><div class="card bg-dark text-white"><div class="card-body"><h5>Total Sales</h5><h3>₹{{ number_format($totals['sales'], 2) }}</h3></div></div></div>
    <div class="col-md-3 mb-3"><div class="card bg-secondary text-white"><div class="card-body"><h5>Total Purchases</h5><h3>₹{{ number_format($totals['purchases'], 2) }}</h3></div></div></div>
    <div class="col-md-3 mb-3"><div class="card bg-danger text-white"><div class="card-body"><h5>Total Expenses</h5><h3>₹{{ number_format($totals['expenses'], 2) }}</h3></div></div></div>
    <div class="col-md-3 mb-3"><div class="card bg-primary text-white"><div class="card-body"><h5>Total Payments</h5><h3>₹{{ number_format($totals['payments'], 2) }}</h3></div></div></div>
</div>

<div class="row">
    <div class="col-md-8">
        <h4>Recent Sales</h4>
        <table class="table table-bordered">
            <thead><tr><th>Number</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($recent['sales'] as $s)
                <tr><td>{{ $s->invoice_number }}</td><td>{{ $s->customer->name ?? '' }}</td><td>{{ $s->total }}</td><td>{{ $s->status }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <h4>Exchange Rates (vs USD)</h4>
        @if(!empty($rates))
            <ul class="list-group">
                <li class="list-group-item">INR: {{ $rates['INR'] ?? 'N/A' }}</li>
                <li class="list-group-item">EUR: {{ $rates['EUR'] ?? 'N/A' }}</li>
                <li class="list-group-item">GBP: {{ $rates['GBP'] ?? 'N/A' }}</li>
            </ul>
        @else
            <div class="alert alert-warning">API unavailable at this moment.</div>
        @endif
    </div>
</div>
@endsection