import React from 'react';
import { Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Employee {
    id: number;
    employee_id: string;
    first_name: string;
    last_name: string;
    department: string;
    position: string;
    status: string;
}

interface WarehouseItem {
    id: number;
    item_code: string;
    name: string;
    quantity: number;
    min_quantity: number;
}

interface FinancialTransaction {
    id: number;
    transaction_id: string;
    type: string;
    amount: number;
    description: string;
    employee?: Employee;
}

interface Props {
    employeeStats?: {
        total: number;
        active: number;
        departments: number;
    };
    warehouseStats?: {
        total_items: number;
        low_stock: number;
        total_value: number;
    };
    financeStats?: {
        total_income: number;
        total_expenses: number;
        balance: number;
        monthly_income: number;
        monthly_expenses: number;
        monthly_balance: number;
    };
    recentTransactions?: FinancialTransaction[];
    lowStockItems?: WarehouseItem[];
    [key: string]: unknown;
}

export default function Welcome({
    employeeStats,
    warehouseStats,
    financeStats,
    recentTransactions = [],
    lowStockItems = []
}: Props) {
    return (
        <AppShell>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                {/* Hero Section */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20">
                    <div className="container mx-auto px-4">
                        <div className="text-center">
                            <h1 className="text-5xl font-bold mb-6">
                                🏢 Company Operations Hub
                            </h1>
                            <p className="text-xl mb-8 max-w-3xl mx-auto">
                                Streamline your business operations with our comprehensive management system.
                                Handle employee data, warehouse inventory, and financial transactions all in one place.
                            </p>
                            <div className="space-x-4">
                                <Link href="/login">
                                    <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100">
                                        🚀 Get Started
                                    </Button>
                                </Link>
                                <Link href="/register">
                                    <Button size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600">
                                        📝 Sign Up Free
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Features Section */}
                <div className="py-20">
                    <div className="container mx-auto px-4">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl font-bold text-gray-800 mb-4">
                                🎯 Complete Business Management Suite
                            </h2>
                            <p className="text-gray-600 max-w-2xl mx-auto">
                                Everything you need to manage your company's operations efficiently and effectively.
                            </p>
                        </div>

                        <div className="grid md:grid-cols-3 gap-8 mb-16">
                            {/* Employee Management */}
                            <Card className="text-center border-2 border-blue-200 hover:border-blue-300 transition-colors">
                                <CardHeader>
                                    <div className="text-4xl mb-4">👥</div>
                                    <CardTitle className="text-blue-700">Employee Management</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-600 mb-4">
                                        Comprehensive employee data management with department tracking, 
                                        salary management, and status monitoring.
                                    </p>
                                    {employeeStats && (
                                        <div className="bg-blue-50 p-4 rounded-lg">
                                            <div className="text-2xl font-bold text-blue-700">{employeeStats.total}</div>
                                            <div className="text-sm text-blue-600">Total Employees</div>
                                            <div className="text-xs text-gray-500 mt-1">
                                                {employeeStats.active} Active • {employeeStats.departments} Departments
                                            </div>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>

                            {/* Warehouse Management */}
                            <Card className="text-center border-2 border-green-200 hover:border-green-300 transition-colors">
                                <CardHeader>
                                    <div className="text-4xl mb-4">📦</div>
                                    <CardTitle className="text-green-700">Warehouse Management</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-600 mb-4">
                                        Real-time inventory tracking with low-stock alerts, 
                                        category management, and supplier information.
                                    </p>
                                    {warehouseStats && (
                                        <div className="bg-green-50 p-4 rounded-lg">
                                            <div className="text-2xl font-bold text-green-700">{warehouseStats.total_items}</div>
                                            <div className="text-sm text-green-600">Items in Stock</div>
                                            <div className="text-xs text-gray-500 mt-1">
                                                {warehouseStats.low_stock} Low Stock • ${warehouseStats.total_value.toFixed(2)} Value
                                            </div>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>

                            {/* Finance Management */}
                            <Card className="text-center border-2 border-yellow-200 hover:border-yellow-300 transition-colors">
                                <CardHeader>
                                    <div className="text-4xl mb-4">💰</div>
                                    <CardTitle className="text-yellow-700">Cash Finance Management</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-600 mb-4">
                                        Complete financial transaction management with income/expense tracking, 
                                        reporting, and cash flow analysis.
                                    </p>
                                    {financeStats && (
                                        <div className="bg-yellow-50 p-4 rounded-lg">
                                            <div className={`text-2xl font-bold ${financeStats.balance >= 0 ? 'text-green-700' : 'text-red-700'}`}>
                                                ${financeStats.balance.toFixed(2)}
                                            </div>
                                            <div className="text-sm text-yellow-600">Current Balance</div>
                                            <div className="text-xs text-gray-500 mt-1">
                                                ${financeStats.monthly_income.toFixed(2)} Income • ${financeStats.monthly_expenses.toFixed(2)} Expenses
                                            </div>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>
                        </div>

                        {/* Live Data Section */}
                        {(recentTransactions.length > 0 || lowStockItems.length > 0) && (
                            <div className="grid md:grid-cols-2 gap-8 mb-16">
                                {/* Recent Transactions */}
                                {recentTransactions.length > 0 && (
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className="flex items-center gap-2">
                                                ⚡ Recent Transactions
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-3">
                                                {recentTransactions.slice(0, 5).map((transaction) => (
                                                    <div key={transaction.id} className="flex justify-between items-center p-3 bg-gray-50 rounded">
                                                        <div>
                                                            <div className="font-medium">{transaction.description}</div>
                                                            <div className="text-sm text-gray-500">
                                                                {transaction.transaction_id}
                                                                {transaction.employee && ` • ${transaction.employee.first_name} ${transaction.employee.last_name}`}
                                                            </div>
                                                        </div>
                                                        <div className={`font-bold ${transaction.type === 'income' ? 'text-green-600' : 'text-red-600'}`}>
                                                            {transaction.type === 'income' ? '+' : '-'}${transaction.amount}
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                )}

                                {/* Low Stock Alerts */}
                                {lowStockItems.length > 0 && (
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className="flex items-center gap-2 text-orange-600">
                                                ⚠️ Low Stock Alerts
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-3">
                                                {lowStockItems.slice(0, 5).map((item) => (
                                                    <div key={item.id} className="flex justify-between items-center p-3 bg-orange-50 rounded border border-orange-200">
                                                        <div>
                                                            <div className="font-medium">{item.name}</div>
                                                            <div className="text-sm text-gray-500">{item.item_code}</div>
                                                        </div>
                                                        <div className="text-right">
                                                            <div className="font-bold text-orange-600">{item.quantity} left</div>
                                                            <div className="text-xs text-gray-500">Min: {item.min_quantity}</div>
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                )}
                            </div>
                        )}

                        {/* Key Features */}
                        <div className="bg-white rounded-lg p-8 shadow-lg">
                            <h3 className="text-2xl font-bold text-gray-800 mb-6 text-center">
                                🌟 Key Features & Benefits
                            </h3>
                            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div className="text-center">
                                    <div className="text-3xl mb-3">🔒</div>
                                    <h4 className="font-semibold text-gray-700 mb-2">Decentralized Access</h4>
                                    <p className="text-sm text-gray-600">Role-based permissions for each module</p>
                                </div>
                                <div className="text-center">
                                    <div className="text-3xl mb-3">⚡</div>
                                    <h4 className="font-semibold text-gray-700 mb-2">Real-time Updates</h4>
                                    <p className="text-sm text-gray-600">Live data synchronization across all modules</p>
                                </div>
                                <div className="text-center">
                                    <div className="text-3xl mb-3">💬</div>
                                    <h4 className="font-semibold text-gray-700 mb-2">Internal Chat</h4>
                                    <p className="text-sm text-gray-600">Built-in communication system</p>
                                </div>
                                <div className="text-center">
                                    <div className="text-3xl mb-3">🔔</div>
                                    <h4 className="font-semibold text-gray-700 mb-2">Smart Notifications</h4>
                                    <p className="text-sm text-gray-600">Instant alerts and reminders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                <div className="bg-gray-800 text-white py-16">
                    <div className="container mx-auto px-4 text-center">
                        <h3 className="text-3xl font-bold mb-4">
                            Ready to Transform Your Operations?
                        </h3>
                        <p className="text-xl mb-8 max-w-2xl mx-auto">
                            Join thousands of companies already using our platform to streamline their operations and boost productivity.
                        </p>
                        <div className="space-x-4">
                            <Link href="/register">
                                <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
                                    🚀 Start Free Trial
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-gray-800">
                                    👤 Login
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}