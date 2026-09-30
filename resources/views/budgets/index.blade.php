@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Budgets</h2>
    <a href="{{ route('budgets.create') }}" class='btn btn-primary'>Add Budget</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Name</th>
                        <th>Period</th>
                        <th class='text-end'>Amount</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($budgets as $b)
                    <tr>
                        <td>{{ $b->name }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($b->period_type ?? $b->period) }}</span></td>
                        <td class='text-end'>{{ number_format($b->amount, 2) }}</td>
                        <td class='text-center'>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href='{{ route('budgets.show', $b) }}' class='btn btn-sm btn-info text-white'>View</a>
                                <a href='{{ route('budgets.edit', $b) }}' class='btn btn-sm btn-warning'>Edit</a>
                                <form action='{{ route('budgets.destroy', $b) }}' method='POST' class='d-inline'>
                                    @csrf @method('DELETE')
                                    <button class='btn btn-sm btn-danger' onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='4' class='text-center text-muted'>No Budgets found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $budgets->links() }}
        </div>
    </div>
</div>
@endsection