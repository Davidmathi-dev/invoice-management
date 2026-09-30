@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Sales Invoices</h2>
    <a href="{{ route('sales-invoices.create') }}" class='btn btn-primary'>Add Invoice</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Number</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th class='text-end'>Total</th>
                        <th class='text-center'>Status</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    <tr>
                        <td><strong>{{ $inv->invoice_number }}</strong></td>
                        <td>{{ $inv->customer->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($inv->invoice_date)->format('M d, Y') }}</td>
                        <td class='text-end'>{{ number_format($inv->total, 2) }}</td>
                        <td class='text-center'>
                            <span class="badge bg-{{ $inv->status == 'Paid' ? 'success' : ($inv->status == 'Overdue' ? 'danger' : 'warning') }}">{{ $inv->status }}</span>
                        </td>
                        <td class='text-center'>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('sales-invoices.show', $inv) }}" class='btn btn-sm btn-info text-white'>View</a>
                                <a href="{{ route('sales-invoices.edit', $inv) }}" class='btn btn-sm btn-warning'>Edit</a>
                                <form action="{{ route('sales-invoices.destroy', $inv) }}" method='POST' class='d-inline'>
                                    @csrf @method('DELETE')
                                    <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='6' class='text-center text-muted'>No invoices found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection