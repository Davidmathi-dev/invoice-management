@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Expenses</h2>
    <a href="{{ route('expenses.create') }}" class='btn btn-primary'>Add Expense</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Date</th>
                        <th>Budget</th>
                        <th>Description</th>
                        <th class='text-end'>Amount</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $e)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($e->expense_date)->format('M d, Y') }}</td>
                        <td>{{ $e->budget->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($e->description, 50) }}</td>
                        <td class='text-end'>{{ number_format($e->amount, 2) }}</td>
                        <td class='text-center'>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href='{{ route('expenses.show', $e) }}' class='btn btn-sm btn-info text-white'>View</a>
                                <a href='{{ route('expenses.edit', $e) }}' class='btn btn-sm btn-warning'>Edit</a>
                                <form action='{{ route('expenses.destroy', $e) }}' method='POST' class='d-inline'>
                                    @csrf @method('DELETE')
                                    <button class='btn btn-sm btn-danger' onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='5' class='text-center text-muted'>No Expenses found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection