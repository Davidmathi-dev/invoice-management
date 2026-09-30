@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class='btn btn-primary'>Add Product</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th class='text-end'>Price</th>
                        <th class='text-end'>Tax rate</th>
                        <th class='text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($item->type) }}</span></td>
                        <td>{{ Str::limit($item->description, 50) }}</td>
                        <td class='text-end'>{{ number_format($item->price, 2) }}</td>
                        <td class='text-end'>{{ number_format($item->tax_rate, 2) }}%</td>
                        <td class='text-center'>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('products.show', $item) }}" class='btn btn-sm btn-info text-white'>View</a>
                                <a href="{{ route('products.edit', $item) }}" class='btn btn-sm btn-warning'>Edit</a>
                                <form action="{{ route('products.destroy', $item) }}" method='POST' class='d-inline'>
                                    @csrf @method('DELETE')
                                    <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='6' class='text-center text-muted'>No Products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection