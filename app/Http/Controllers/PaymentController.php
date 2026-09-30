<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('salesInvoice')->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $invoices = SalesInvoice::where('status', '!=', 'Paid')->get();
        return view('payments.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sales_invoice_id' => 'required|exists:sales_invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            Payment::create($request->all());
            
            $invoice = SalesInvoice::findOrFail($request->sales_invoice_id);
            $totalPaid = $invoice->payments()->sum('amount');
            
            if ($totalPaid >= $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            } elseif ($totalPaid > 0) {
                $invoice->update(['status' => 'Pending']);
            }
        });

        return redirect()->route('payments.index')->with('success', 'Payment recorded.');
    }

    public function show(Payment $payment)
    {
        $payment->load('salesInvoice');
        return view('payments.show', compact('payment'));
    }

    // Edit/update/destroy can be standard, but omitted complex status recalculation for brevity
    public function edit(Payment $payment)
    {
        $invoices = SalesInvoice::all();
        return view('payments.edit', compact('payment', 'invoices'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'sales_invoice_id' => 'required|exists:sales_invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $payment) {
            $payment->update($request->all());
            
            $invoice = SalesInvoice::findOrFail($request->sales_invoice_id);
            $totalPaid = $invoice->payments()->sum('amount');
            
            if ($totalPaid >= $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            } elseif ($totalPaid > 0) {
                // Should also check due date for Overdue in a real scenario
                $invoice->update(['status' => 'Pending']);
            } else {
                $invoice->update(['status' => 'Pending']);
            }
        });

        return redirect()->route('payments.index')->with('success', 'Payment updated.');
    }

    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            $invoiceId = $payment->sales_invoice_id;
            $payment->delete();
            
            $invoice = SalesInvoice::findOrFail($invoiceId);
            $totalPaid = $invoice->payments()->sum('amount');
            
            if ($totalPaid >= $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            } elseif ($totalPaid > 0) {
                $invoice->update(['status' => 'Pending']);
            } else {
                $invoice->update(['status' => 'Pending']);
            }
        });
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}