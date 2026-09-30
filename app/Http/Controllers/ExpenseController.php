<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('budget')->latest()->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $budgets = Budget::all();
        return view('expenses.create', compact('budgets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Expense created.');
    }

    public function show(Expense $expense)
    {
        $expense->load('budget');
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $budgets = Budget::all();
        return view('expenses.edit', compact('expense', 'budgets'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted.');
    }
}