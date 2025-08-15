<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WarehouseItem;
use App\Models\FinancialTransaction;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index()
    {
        // Employee statistics
        $employeeStats = [
            'total' => Employee::count(),
            'active' => Employee::active()->count(),
            'departments' => Employee::select('department')->distinct()->count(),
        ];

        // Warehouse statistics
        $warehouseStats = [
            'total_items' => WarehouseItem::count(),
            'low_stock' => WarehouseItem::lowStock()->active()->count(),
            'total_value' => WarehouseItem::active()->get()->sum(function($item) {
                return $item->quantity * (float) $item->unit_price;
            }),
        ];

        // Financial statistics
        $currentMonth = now()->format('Y-m');
        $totalIncome = FinancialTransaction::income()->completed()->sum('amount');
        $totalExpenses = FinancialTransaction::expense()->completed()->sum('amount');
        $monthlyIncome = FinancialTransaction::income()->completed()
            ->whereBetween('transaction_date', [
                now()->startOfMonth()->format('Y-m-d'),
                now()->endOfMonth()->format('Y-m-d')
            ])
            ->sum('amount');
        $monthlyExpenses = FinancialTransaction::expense()->completed()
            ->whereBetween('transaction_date', [
                now()->startOfMonth()->format('Y-m-d'),
                now()->endOfMonth()->format('Y-m-d')
            ])
            ->sum('amount');

        $financeStats = [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'balance' => $totalIncome - $totalExpenses,
            'monthly_income' => $monthlyIncome,
            'monthly_expenses' => $monthlyExpenses,
            'monthly_balance' => $monthlyIncome - $monthlyExpenses,
        ];

        // Recent activities
        $recentTransactions = FinancialTransaction::with('employee')
            ->latest()
            ->take(5)
            ->get();

        $lowStockItems = WarehouseItem::lowStock()
            ->active()
            ->take(5)
            ->get();

        return Inertia::render('welcome', [
            'employeeStats' => $employeeStats,
            'warehouseStats' => $warehouseStats,
            'financeStats' => $financeStats,
            'recentTransactions' => $recentTransactions,
            'lowStockItems' => $lowStockItems,
        ]);
    }
}