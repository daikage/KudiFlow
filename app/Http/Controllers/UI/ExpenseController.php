<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('tenant_id', app('tenant_id'))->latest()->paginate(20);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(ExpenseRequest $request)
    {
        Expense::create($request->validated() + ['tenant_id' => app('tenant_id')]);
        return redirect()->route('ui.expenses.index')->with('success', 'Expense saved.');
    }

    public function show(Expense $expense)
    {
        $this->authorizeExpense($expense);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $this->authorizeExpense($expense);
        return view('expenses.edit', compact('expense'));
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        $this->authorizeExpense($expense);
        $expense->update($request->validated());
        return redirect()->route('ui.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense)
    {
        $this->authorizeExpense($expense);
        $expense->delete();
        return redirect()->route('ui.expenses.index')->with('success', 'Expense deleted.');
    }

    protected function authorizeExpense(Expense $expense): void
    {
        abort_unless($expense->tenant_id === app('tenant_id'), 404);
    }
}
