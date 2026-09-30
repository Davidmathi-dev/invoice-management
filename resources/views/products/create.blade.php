@extends('layouts.app')
@section('content')
<h2>Create Product</h2><div class='card shadow-sm'><div class='card-body'><form method='POST' action="{{ route('products.store') }}">
@csrf
<div class='mb-3'><label>name</label>
<input type='text' name='name' class='form-control @error('name') is-invalid @enderror' value="{{ old('name') }}">
@error('name')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>type</label>
<input type='text' name='type' class='form-control @error('type') is-invalid @enderror' value="{{ old('type') }}">
@error('type')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>description</label>
<textarea name='description' class='form-control @error('description') is-invalid @enderror'>{{ old('description') }}</textarea>
@error('description')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>price</label>
<input type='number' name='price' class='form-control @error('price') is-invalid @enderror' value="{{ old('price') }}" step="0.01">
@error('price')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>tax_rate</label>
<input type='number' name='tax_rate' class='form-control @error('tax_rate') is-invalid @enderror' value="{{ old('tax_rate') }}" step="0.01">
@error('tax_rate')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<button class='btn btn-success'>Save</button> <a href="{{ route('products.index') }}" class='btn btn-secondary'>Cancel</a>
</form></div></div>
@endsection