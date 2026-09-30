@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Invoice Details - {{ $salesInvoice->invoice_number }}</h2>
    <div>
        <a href="{{ route('sales-invoices.edit', $salesInvoice) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('sales-invoices.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div class='card shadow-sm mb-4'>
    <div class='card-body'>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Customer:</strong> {{ $salesInvoice->customer->name }}</p>
                <p><strong>Date:</strong> {{ $salesInvoice->invoice_date }}</p>
                <p><strong>Due Date:</strong> {{ $salesInvoice->due_date }}</p>
            </div>
            <div class="col-md-6">
                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $salesInvoice->status == 'Paid' ? 'success' : ($salesInvoice->status == 'Overdue' ? 'danger' : 'warning') }}">
                        {{ $salesInvoice->status }}
                    </span>
                </p>
                <p><strong>Notes:</strong> {{ $salesInvoice->notes ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>

<h4>Items</h4>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesInvoice->salesInvoiceItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->discount, 2) }}</td>
                        <td>{{ number_format($item->tax_amount, 2) }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><th colspan="5" class="text-end">Subtotal:</th><th>{{ number_format($salesInvoice->subtotal, 2) }}</th></tr>
                    <tr><th colspan="5" class="text-end">Discount:</th><th>{{ number_format($salesInvoice->discount, 2) }}</th></tr>
                    <tr><th colspan="5" class="text-end">Tax:</th><th>{{ number_format($salesInvoice->tax, 2) }}</th></tr>
                    <tr class="table-dark"><th colspan="5" class="text-end">Grand Total:</th><th>{{ number_format($salesInvoice->total, 2) }}</th></tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection