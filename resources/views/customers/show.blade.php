@extends('layouts.app')
@section('content')
<h2>Customer Details</h2><div class='card shadow-sm'><div class='card-body'>
<p><strong>Name:</strong> {{ $customer->name }}</p>
<p><strong>Email:</strong> {{ $customer->email }}</p>
<p><strong>Phone:</strong> {{ $customer->phone }}</p>
<p><strong>Address:</strong> {{ $customer->address }}</p>
<a href="{{ route('customers.index') }}" class='btn btn-secondary'>Back</a>
</div></div>
@endsection