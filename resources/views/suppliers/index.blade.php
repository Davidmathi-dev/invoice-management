@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Suppliers</h2>
    <a href="{{ route('suppliers.create') }}" class='btn btn-primary'>Add Supplier</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ Str::limit($item->address, 50) }}</td>
                        <td class='text-center'>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('suppliers.show', $item) }}" class='btn btn-sm btn-info text-white'>View</a>
                                <a href="{{ route('suppliers.edit', $item) }}" class='btn btn-sm btn-warning'>Edit</a>
                                <form action="{{ route('suppliers.destroy', $item) }}" method='POST' class='d-inline'>
                                    @csrf @method('DELETE')
                                    <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='5' class='text-center text-muted'>No Suppliers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection