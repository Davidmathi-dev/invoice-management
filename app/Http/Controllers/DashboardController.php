<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\SalesInvoice;
use App\Models\Supplier;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'customers' => Customer::count(),
            'suppliers' => Supplier::count(),
            'products' => Product::count(),
            'sales_invoices' => SalesInvoice::count(),
            'purchase_invoices' => PurchaseInvoice::count(),
        ];

        $totals = [
            'sales' => SalesInvoice::sum('total'),
            'purchases' => PurchaseInvoice::sum('total'),
            'expenses' => Expense::sum('amount'),
            'payments' => Payment::sum('amount'),
            'outstanding' => SalesInvoice::sum('total') - Payment::sum('amount'), // simplified
        ];

        $recent = [
            'sales' => SalesInvoice::with('customer')->latest()->take(5)->get(),
            'purchases' => PurchaseInvoice::with('supplier')->latest()->take(5)->get(),
            'expenses' => Expense::with('budget')->latest()->take(5)->get(),
        ];

        // API Call - Frankfurter exchange rates
        $rates = Cache::remember('exchange_rates', 3600, function () {
            try {
                $response = Http::timeout(5)->withoutVerifying()->get('https://api.frankfurter.dev/v2/rates', [
                    'base'   => 'USD',
                    'quotes' => 'INR,EUR,GBP',
                ]);

                if ($response->successful()) {
                    // Response is an array of {date, base, quote, rate} objects
                    $parsed = [];
                    foreach ($response->json() as $item) {
                        $parsed[$item['quote']] = $item['rate'];
                    }

                    return $parsed; // e.g. ['INR' => 95.92, 'EUR' => 0.88, 'GBP' => 0.75]
                }
            } catch (\Exception $e) {
                // Fail gracefully — do not break the dashboard
            }

            return [];
        });

        return view('dashboard.index', compact('counts', 'totals', 'recent', 'rates'));
    }
}
