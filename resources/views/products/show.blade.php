@extends('layouts.app')
@section('content')
<h2>Product Details</h2><div class='card shadow-sm'><div class='card-body'>
<p><strong>Name:</strong> {{ $product->name }}</p>
<p><strong>Type:</strong> {{ $product->type }}</p>
<p><strong>Description:</strong> {{ $product->description }}</p>
<p><strong>Price:</strong> {{ $product->price }}</p>
<p><strong>Tax rate:</strong> {{ $product->tax_rate }}</p>
<a href="{{ route('products.index') }}" class='btn btn-secondary'>Back</a>
</div></div>
@endsection