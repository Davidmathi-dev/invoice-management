<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\InvoiceCalculationService;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        $invoices = PurchaseInvoice::with('supplier')->latest()->paginate(10);
        return view('purchase-invoices.index', compact('invoices'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase-invoices.create', compact('suppliers', 'products'));
    }

    public function store(Request $request, InvoiceCalculationService $calculator)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|unique:purchase_invoices',
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
            $invoice = PurchaseInvoice::create([
                'supplier_id' => $request->supplier_id,
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
                $invoice->purchaseInvoiceItems()->create([
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

        return redirect()->route('purchase-invoices.index')->with('success', 'Purchase Invoice created successfully.');
    }

    public function show(PurchaseInvoice $purchaseInvoice)
    {
        $purchaseInvoice->load(['supplier', 'purchaseInvoiceItems.product']);
        return view('purchase-invoices.show', compact('purchaseInvoice'));
    }

    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        $purchaseInvoice->load('purchaseInvoiceItems');
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase-invoices.edit', compact('purchaseInvoice', 'suppliers', 'products'));
    }

    public function update(Request $request, PurchaseInvoice $purchaseInvoice, InvoiceCalculationService $calculator)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|unique:purchase_invoices,invoice_number,' . $purchaseInvoice->id,
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

        DB::transaction(function () use ($request, $purchaseInvoice, $calculated) {
            $purchaseInvoice->update([
                'supplier_id' => $request->supplier_id,
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

            $purchaseInvoice->purchaseInvoiceItems()->delete();

            foreach ($calculated['items'] as $item) {
                $purchaseInvoice->purchaseInvoiceItems()->create([
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

        return redirect()->route('purchase-invoices.index')->with('success', 'Purchase Invoice updated successfully.');
    }

    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        DB::transaction(function () use ($purchaseInvoice) {
            $purchaseInvoice->purchaseInvoiceItems()->delete();
            $purchaseInvoice->delete();
        });
        return redirect()->route('purchase-invoices.index')->with('success', 'Purchase Invoice deleted successfully.');
    }
}