@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Payments</h2>
    <a href="{{ route('payments.create') }}" class='btn btn-primary'>Add Payment</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th class='text-end'>Amount</th>
                        <th>Method</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('M d, Y') }}</td>
                        <td>{{ $p->salesInvoice->invoice_number ?? 'N/A' }}</td>
                        <td class='text-end'>{{ number_format($p->amount, 2) }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($p->payment_method) }}</span></td>
                        <td class='text-center'>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href='{{ route('payments.show', $p) }}' class='btn btn-sm btn-info text-white'>View</a>
                                <a href='{{ route('payments.edit', $p) }}' class='btn btn-sm btn-warning'>Edit</a>
                                <form action='{{ route('payments.destroy', $p) }}' method='POST' class='d-inline'>
                                    @csrf @method('DELETE')
                                    <button class='btn btn-sm btn-danger' onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='5' class='text-center text-muted'>No Payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection