@extends('layouts.app')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2>Edit Expense</h2>
    <a href="{{ route('expenses.index') }}" class='btn btn-secondary'>← Back</a>
</div>
<div class='card shadow-sm'>
    <div class='card-body'>
        <form action='{{ route('expenses.update', $expense) }}' method='POST'>
            @csrf @method('PUT')
            <div class='mb-3'>
                <label class='form-label'>Budget</label>
                <select name='budget_id' class='form-select'>
                    @foreach($budgets as $b)
                        <option value='{{ $b->id }}' {{ $expense->budget_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Description</label>
                <input type='text' name='description' class='form-control' value='{{ $expense->description }}' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Amount</label>
                <input type='number' name='amount' class='form-control' value='{{ $expense->amount }}' step='0.01' min='0' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Date</label>
                <input type='date' name='expense_date' class='form-control' value='{{ $expense->expense_date }}' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Category</label>
                <input type='text' name='category' class='form-control' value='{{ $expense->category }}' required>
            </div>
            <button class='btn btn-success'>Update Expense</button>
        </form>
    </div>
</div>
@endsection