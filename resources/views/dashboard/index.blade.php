@extends('layouts.app')
@section('content')

<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h2><i class="bi bi-grid-1x2-fill text-primary me-2" style="font-size:1.1rem;"></i>Dashboard</h2>
        <p class="text-muted mb-0" style="font-size:0.83rem; margin-top:2px;">
            Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here's your financial overview.
        </p>
    </div>
    <span class="badge bg-primary px-3 py-2" style="border-radius:50px;font-size:0.78rem;">
        <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d M Y') }}
    </span>
</div>

<!-- Count Cards -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:46px;height:46px;background:rgba(255,255,255,0.18);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-people-fill text-white" style="font-size:1.15rem;"></i>
                </div>
                <div>
                    <p class="text-white mb-0" style="font-size:0.76rem;opacity:0.82;font-weight:500;">Customers</p>
                    <h3 class="text-white mb-0 fw-bold">{{ $counts['customers'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background:linear-gradient(135deg,#10b981,#059669);">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:46px;height:46px;background:rgba(255,255,255,0.18);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-truck text-white" style="font-size:1.15rem;"></i>
                </div>
                <div>
                    <p class="text-white mb-0" style="font-size:0.76rem;opacity:0.82;font-weight:500;">Suppliers</p>
                    <h3 class="text-white mb-0 fw-bold">{{ $counts['suppliers'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:46px;height:46px;background:rgba(255,255,255,0.18);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-box-seam-fill text-white" style="font-size:1.15rem;"></i>
                </div>
                <div>
                    <p class="text-white mb-0" style="font-size:0.76rem;opacity:0.82;font-weight:500;">Products</p>
                    <h3 class="text-white mb-0 fw-bold">{{ $counts['products'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:46px;height:46px;background:rgba(255,255,255,0.18);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-file-earmark-text-fill text-white" style="font-size:1.15rem;"></i>
                </div>
                <div>
                    <p class="text-white mb-0" style="font-size:0.76rem;opacity:0.82;font-weight:500;">Sales Invoices</p>
                    <h3 class="text-white mb-0 fw-bold">{{ $counts['sales_invoices'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Totals -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted" style="font-size:0.78rem;font-weight:500;">Total Sales</span>
                    <span style="width:32px;height:32px;background:#dbeafe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-graph-up-arrow text-primary" style="font-size:0.85rem;"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-0" style="color:#0f172a;">₹{{ number_format($totals['sales'], 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted" style="font-size:0.78rem;font-weight:500;">Total Purchases</span>
                    <span style="width:32px;height:32px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-graph-down-arrow text-secondary" style="font-size:0.85rem;"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-0" style="color:#0f172a;">₹{{ number_format($totals['purchases'], 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted" style="font-size:0.78rem;font-weight:500;">Total Expenses</span>
                    <span style="width:32px;height:32px;background:#fee2e2;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-credit-card-fill text-danger" style="font-size:0.85rem;"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-0" style="color:#0f172a;">₹{{ number_format($totals['expenses'], 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted" style="font-size:0.78rem;font-weight:500;">Total Payments</span>
                    <span style="width:32px;height:32px;background:#d1fae5;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-cash-stack text-success" style="font-size:0.85rem;"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-0" style="color:#0f172a;">₹{{ number_format($totals['payments'], 2) }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Bottom: Recent Sales + Exchange Rates -->
<div class="row g-3">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 fw-bold" style="color:#0f172a;">
                        <i class="bi bi-file-earmark-text text-primary me-2"></i>Recent Sales
                    </h6>
                    <a href="{{ route('sales-invoices.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius:50px;font-size:0.76rem;padding:4px 12px;">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent['sales'] as $s)
                            <tr>
                                <td><span class="fw-semibold" style="color:#3b82f6;">{{ $s->invoice_number }}</span></td>
                                <td>{{ $s->customer->name ?? '—' }}</td>
                                <td class="text-end fw-semibold">₹{{ number_format($s->total, 2) }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $s->status == 'Paid' ? 'success' : ($s->status == 'Overdue' ? 'danger' : 'warning') }}">
                                        {{ $s->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No recent sales found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="mb-3 fw-bold" style="color:#0f172a;">
                    <i class="bi bi-currency-exchange text-warning me-2"></i>Exchange Rates (vs USD)
                </h6>
                @if(!empty($rates))
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#dbeafe;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:1.2rem;">🇮🇳</span>
                                <span class="fw-semibold" style="color:#1d4ed8;font-size:0.88rem;">INR</span>
                            </div>
                            <span class="fw-bold" style="color:#1d4ed8;font-size:0.95rem;">{{ $rates['INR'] ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#d1fae5;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:1.2rem;">🇪🇺</span>
                                <span class="fw-semibold" style="color:#065f46;font-size:0.88rem;">EUR</span>
                            </div>
                            <span class="fw-bold" style="color:#065f46;font-size:0.95rem;">{{ $rates['EUR'] ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#fce7f3;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:1.2rem;">🇬🇧</span>
                                <span class="fw-semibold" style="color:#9d174d;font-size:0.88rem;">GBP</span>
                            </div>
                            <span class="fw-bold" style="color:#9d174d;font-size:0.95rem;">{{ $rates['GBP'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0 text-center" style="font-size:0.7rem;">
                        <i class="bi bi-info-circle me-1"></i>Powered by Frankfurter API
                    </p>
                @else
                    <div class="alert alert-warning d-flex align-items-center gap-2 mb-0">
                        <i class="bi bi-exclamation-triangle-fill"></i> API unavailable at this moment.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection