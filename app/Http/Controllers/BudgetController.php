<?php
namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::latest()->paginate(10);
        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string',
            'period_type' => 'required|in:monthly,yearly',
            'amount'      => 'required|numeric|min:0',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
        ]);
        Budget::create($validated);
        return redirect()->route('budgets.index')->with('success', 'Budget created.');
    }

    public function show(Budget $budget)
    {
        // Load expenses and calculate usage
        $budget->load('expenses');
        $spent = $budget->expenses->sum('amount');
        $remaining = $budget->amount - $spent;
        $usage = $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0;
        
        return view('budgets.show', compact('budget', 'spent', 'remaining', 'usage'));
    }

    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'name'        => 'required|string',
            'period_type' => 'required|in:monthly,yearly',
            'amount'      => 'required|numeric|min:0',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
        ]);
        $budget->update($validated);
        return redirect()->route('budgets.index')->with('success', 'Budget updated.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget deleted.');
    }
}