@extends('layouts.app')
@section('content')
<h2>Payment Details</h2><p>Invoice: {{ $payment->salesInvoice->invoice_number ?? 'N/A' }}</p><p>Amount: {{ $payment->amount }}</p><p>Date: {{ $payment->payment_date }}</p><p>Method: {{ $payment->payment_method }}</p><a href='{{ route('payments.index') }}' class='btn btn-secondary'>Back</a>@endsection