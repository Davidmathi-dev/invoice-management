<?php
namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\Expense;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $querySales = SalesInvoice::query();
        $queryPurchases = PurchaseInvoice::query();
        $queryExpenses = Expense::query();
        
        if($request->filled('from_date')) {
            $querySales->whereDate('invoice_date', '>=', $request->from_date);
            $queryPurchases->whereDate('invoice_date', '>=', $request->from_date);
            $queryExpenses->whereDate('expense_date', '>=', $request->from_date);
        }
        
        if($request->filled('to_date')) {
            $querySales->whereDate('invoice_date', '<=', $request->to_date);
            $queryPurchases->whereDate('invoice_date', '<=', $request->to_date);
            $queryExpenses->whereDate('expense_date', '<=', $request->to_date);
        }

        $reports = [
            'total_sales' => $querySales->sum('total'),
            'paid_sales' => (clone $querySales)->where('status', 'Paid')->sum('total'),
            'pending_sales' => (clone $querySales)->where('status', 'Pending')->sum('total'),
            
            'total_purchases' => $queryPurchases->sum('total'),
            'total_expenses' => $queryExpenses->sum('amount'),
        ];
        
        // Group by for a simple chart/table
        $salesByStatus = (clone $querySales)->selectRaw('status, sum(total) as amount')->groupBy('status')->get();

        return view('reports.index', compact('reports', 'salesByStatus'));
    }
}