@extends('layouts.app')
@section('content')
<h2>Expense Details</h2><p>Budget: {{ $expense->budget->name ?? 'N/A' }}</p><p>Description: {{ $expense->description }}</p><p>Amount: {{ $expense->amount }}</p><p>Date: {{ $expense->expense_date }}</p><p>Category: {{ $expense->category }}</p><a href='{{ route('expenses.index') }}' class='btn btn-secondary'>Back</a>@endsection