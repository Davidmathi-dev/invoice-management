@extends('layouts.app')
@section('content')
<h2>Create Supplier</h2><div class='card shadow-sm'><div class='card-body'><form method='POST' action="{{ route('suppliers.store') }}">
@csrf
<div class='mb-3'><label>name</label>
<input type='text' name='name' class='form-control @error('name') is-invalid @enderror' value="{{ old('name') }}">
@error('name')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>email</label>
<input type='email' name='email' class='form-control @error('email') is-invalid @enderror' value="{{ old('email') }}">
@error('email')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>phone</label>
<input type='text' name='phone' class='form-control @error('phone') is-invalid @enderror' value="{{ old('phone') }}">
@error('phone')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>address</label>
<textarea name='address' class='form-control @error('address') is-invalid @enderror'>{{ old('address') }}</textarea>
@error('address')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<button class='btn btn-success'>Save</button> <a href="{{ route('suppliers.index') }}" class='btn btn-secondary'>Cancel</a>
</form></div></div>
@endsection