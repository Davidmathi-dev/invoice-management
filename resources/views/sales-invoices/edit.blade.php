@extends('layouts.app')
@section('content')
<h2>Edit Sales Invoice</h2>
@if($errors->any()) <div class="alert alert-danger"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div> @endif
<div class='card shadow-sm'><div class='card-body'>
<form method='POST' action="{{ route('sales-invoices.update', $salesInvoice) }}">
@csrf @method('PUT')
@include('sales-invoices._form')
<button class='btn btn-success mt-3'>Update Invoice</button>
<a href="{{ route('sales-invoices.index') }}" class='btn btn-secondary mt-3'>Cancel</a>
</form>
</div></div>
@endsection