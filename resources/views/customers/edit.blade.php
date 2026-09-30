@extends('layouts.app')
@section('content')
<h2>Edit Customer</h2><div class='card shadow-sm'><div class='card-body'><form method='POST' action="{{ route('customers.update', $customer) }}">
@csrf @method('PUT')
<div class='mb-3'><label>name</label>
<input type='text' name='name' class='form-control @error('name') is-invalid @enderror' value="{{ old('name', $customer->name) }}">
@error('name')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>email</label>
<input type='email' name='email' class='form-control @error('email') is-invalid @enderror' value="{{ old('email', $customer->email) }}">
@error('email')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>phone</label>
<input type='text' name='phone' class='form-control @error('phone') is-invalid @enderror' value="{{ old('phone', $customer->phone) }}">
@error('phone')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<div class='mb-3'><label>address</label>
<textarea name='address' class='form-control @error('address') is-invalid @enderror'>{{ old('address', $customer->address) }}</textarea>
@error('address')<div class='invalid-feedback'>{{ $message }}</div>@enderror</div>
<button class='btn btn-success'>Update</button> <a href="{{ route('customers.index') }}" class='btn btn-secondary'>Cancel</a>
</form></div></div>
@endsection