@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Edit Budget</h2>
    <a href="{{ route('budgets.index') }}" class='btn btn-secondary'>← Back</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <form action='{{ route('budgets.update', $budget) }}' method='POST'>
            @csrf @method('PUT')
            <div class='mb-3'>
                <label class='form-label'>Name</label>
                <input type='text' name='name' class='form-control' value='{{ $budget->name }}' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Period</label>
                <select name='period_type' class='form-select' required>
                    <option value='monthly' {{ ($budget->period_type ?? $budget->period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value='yearly' {{ ($budget->period_type ?? $budget->period) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Amount</label>
                <input type='number' name='amount' class='form-control' value='{{ $budget->amount }}' step='0.01' min='0' required>
            </div>
            <div class='row mb-3'>
                <div class='col-md-6'>
                    <label class='form-label'>Start Date</label>
                    <input type='date' name='start_date' class='form-control' value='{{ $budget->start_date }}' required>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>End Date</label>
                    <input type='date' name='end_date' class='form-control' value='{{ $budget->end_date }}' required>
                </div>
            </div>
            <button class='btn btn-success'>Update Budget</button>
        </form>
    </div>
</div>
@endsection