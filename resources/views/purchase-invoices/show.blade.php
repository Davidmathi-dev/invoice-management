@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Purchase Invoice Details - {{ $purchaseInvoice->invoice_number }}</h2>
    <div>
        <a href="{{ route('purchase-invoices.edit', $purchaseInvoice) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('purchase-invoices.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>
<div class='card shadow-sm mb-4'>
<div class='card-body'>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Supplier:</strong> {{ $purchaseInvoice->supplier->name }}</p>
            <p><strong>Date:</strong> {{ $purchaseInvoice->invoice_date }}</p>
            <p><strong>Due Date:</strong> {{ $purchaseInvoice->due_date }}</p>
        </div>
        <div class="col-md-6">
            <p>
                <strong>Status:</strong> 
                <span class="badge bg-{{ $purchaseInvoice->status == 'Paid' ? 'success' : ($purchaseInvoice->status == 'Overdue' ? 'danger' : 'warning') }}">
                    {{ $purchaseInvoice->status }}
                </span>
            </p>
            <p><strong>Notes:</strong> {{ $purchaseInvoice->notes ?? '—' }}</p>
        </div>
    </div>
</div>
</div>
<h4>Items</h4>
<div class='card shadow-sm'><div class='card-body'><div class='table-responsive'>
<table class='table table-bordered'>
    <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Discount</th><th>Tax</th><th>Total</th></tr></thead>
    <tbody>
        @foreach($purchaseInvoice->purchaseInvoiceItems as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_price }}</td>
            <td>{{ $item->discount }}</td>
            <td>{{ $item->tax }}</td>
            <td>{{ $item->total }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><th colspan="5" class="text-end">Subtotal:</th><th>{{ $purchaseInvoice->subtotal }}</th></tr>
        <tr><th colspan="5" class="text-end">Discount:</th><th>{{ $purchaseInvoice->discount }}</th></tr>
        <tr><th colspan="5" class="text-end">Tax:</th><th>{{ $purchaseInvoice->tax }}</th></tr>
        <tr><th colspan="5" class="text-end">Grand Total:</th><th>{{ $purchaseInvoice->total }}</th></tr>
    </tfoot>
</table>
</div></div></div>
@endsection