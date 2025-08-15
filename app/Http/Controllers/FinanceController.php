<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinancialTransactionRequest;
use App\Http\Requests\UpdateFinancialTransactionRequest;
use App\Models\FinancialTransaction;
use App\Models\Employee;
use Inertia\Inertia;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = FinancialTransaction::with('employee')
            ->latest()
            ->paginate(10);
        
        $totalIncome = FinancialTransaction::income()->completed()->sum('amount');
        $totalExpenses = FinancialTransaction::expense()->completed()->sum('amount');
        $balance = $totalIncome - $totalExpenses;
        
        return Inertia::render('finance/index', [
            'transactions' => $transactions,
            'summary' => [
                'total_income' => number_format($totalIncome, 2),
                'total_expenses' => number_format($totalExpenses, 2),
                'balance' => number_format($balance, 2),
                'balance_positive' => $balance >= 0
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::active()->get(['id', 'first_name', 'last_name']);
        
        return Inertia::render('finance/create', [
            'employees' => $employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinancialTransactionRequest $request)
    {
        $transaction = FinancialTransaction::create($request->validated());

        return redirect()->route('finance.show', $transaction)
            ->with('success', 'Financial transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialTransaction $finance)
    {
        $finance->load('employee');
        
        return Inertia::render('finance/show', [
            'transaction' => $finance
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialTransaction $finance)
    {
        $employees = Employee::active()->get(['id', 'first_name', 'last_name']);
        
        return Inertia::render('finance/edit', [
            'transaction' => $finance,
            'employees' => $employees
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinancialTransactionRequest $request, FinancialTransaction $finance)
    {
        $finance->update($request->validated());

        return redirect()->route('finance.show', $finance)
            ->with('success', 'Financial transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialTransaction $finance)
    {
        $finance->delete();

        return redirect()->route('finance.index')
            ->with('success', 'Financial transaction deleted successfully.');
    }
}