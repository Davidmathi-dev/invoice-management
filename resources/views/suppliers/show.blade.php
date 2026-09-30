@extends('layouts.app')
@section('content')
<h2>Supplier Details</h2><div class='card shadow-sm'><div class='card-body'>
<p><strong>Name:</strong> {{ $supplier->name }}</p>
<p><strong>Email:</strong> {{ $supplier->email }}</p>
<p><strong>Phone:</strong> {{ $supplier->phone }}</p>
<p><strong>Address:</strong> {{ $supplier->address }}</p>
<a href="{{ route('suppliers.index') }}" class='btn btn-secondary'>Back</a>
</div></div>
@endsection