<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\InvoiceCalculationService;
use Illuminate\Support\Facades\DB;

class SalesInvoiceController extends Controller
{
    public function index()
    {
        $invoices = SalesInvoice::with('customer')->latest()->paginate(10);
        return view('sales-invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('sales-invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request, InvoiceCalculationService $calculator)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:sales_invoices',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.tax_rate' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Paid,Overdue',
        ]);

        $calculated = $calculator->calculate($request->input('items', []));

        DB::transaction(function () use ($request, $calculated) {
            $invoice = SalesInvoice::create([
                'customer_id' => $request->customer_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $calculated['subtotal'],
                'discount' => $calculated['discount'],
                'tax' => $calculated['tax'],
                'total' => $calculated['total'],
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            foreach ($calculated['items'] as $item) {
                $invoice->salesInvoiceItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'],
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $item['tax'],
                    'total' => $item['total'],
                ]);
            }
        });

        return redirect()->route('sales-invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(SalesInvoice $salesInvoice)
    {
        $salesInvoice->load(['customer', 'salesInvoiceItems.product']);
        return view('sales-invoices.show', compact('salesInvoice'));
    }

    public function edit(SalesInvoice $salesInvoice)
    {
        $salesInvoice->load('salesInvoiceItems');
        $customers = Customer::all();
        $products = Product::all();
        return view('sales-invoices.edit', compact('salesInvoice', 'customers', 'products'));
    }

    public function update(Request $request, SalesInvoice $salesInvoice, InvoiceCalculationService $calculator)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:sales_invoices,invoice_number,' . $salesInvoice->id,
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.tax_rate' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Paid,Overdue',
        ]);

        $calculated = $calculator->calculate($request->input('items', []));

        DB::transaction(function () use ($request, $salesInvoice, $calculated) {
            $salesInvoice->update([
                'customer_id' => $request->customer_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $calculated['subtotal'],
                'discount' => $calculated['discount'],
                'tax' => $calculated['tax'],
                'total' => $calculated['total'],
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            $salesInvoice->salesInvoiceItems()->delete();

            foreach ($calculated['items'] as $item) {
                $salesInvoice->salesInvoiceItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'],
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $item['tax'],
                    'total' => $item['total'],
                ]);
            }
        });

        return redirect()->route('sales-invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(SalesInvoice $salesInvoice)
    {
        DB::transaction(function () use ($salesInvoice) {
            $salesInvoice->salesInvoiceItems()->delete();
            $salesInvoice->payments()->delete(); // Or handle carefully based on logic
            $salesInvoice->delete();
        });
        return redirect()->route('sales-invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}