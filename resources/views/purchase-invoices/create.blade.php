@extends('layouts.app')
@section('content')
<h2>Create Purchase Invoice</h2>
@if($errors->any()) <div class="alert alert-danger"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div> @endif
<div class='card shadow-sm'><div class='card-body'>
<form method='POST' action="{{ route('purchase-invoices.store') }}">
@csrf
@include('purchase-invoices._form')
<button class='btn btn-success mt-3'>Save Invoice</button>
<a href="{{ route('purchase-invoices.index') }}" class='btn btn-secondary mt-3'>Cancel</a>
</form>
</div></div>
@endsection