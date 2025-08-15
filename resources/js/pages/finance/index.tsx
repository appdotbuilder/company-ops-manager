import React from 'react';
import { Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Heading from '@/components/heading';

interface Employee {
    id: number;
    first_name: string;
    last_name: string;
}

interface FinancialTransaction {
    id: number;
    transaction_id: string;
    type: string;
    category: string;
    amount: number;
    description: string;
    reference: string;
    account: string;
    transaction_date: string;
    status: string;
    payment_method: string;
    employee?: Employee;
}

interface Props {
    transactions: {
        data: FinancialTransaction[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    summary: {
        total_income: string;
        total_expenses: string;
        balance: string;
        balance_positive: boolean;
    };
    [key: string]: unknown;
}

export default function FinanceIndex({ transactions, summary }: Props) {
    return (
        <AppShell>
            <div className="container mx-auto p-6">
                <div className="flex justify-between items-center mb-6">
                    <Heading title="💰 Finance Management" />
                    <Link href="/finance/create">
                        <Button>➕ Add Transaction</Button>
                    </Link>
                </div>

                {/* Financial Summary */}
                <div className="grid md:grid-cols-3 gap-6 mb-6">
                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-green-600 text-sm">Total Income</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-700">
                                +${summary.total_income}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-red-600 text-sm">Total Expenses</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-red-700">
                                -${summary.total_expenses}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-gray-600 text-sm">Net Balance</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className={`text-2xl font-bold ${summary.balance_positive ? 'text-green-700' : 'text-red-700'}`}>
                                {summary.balance_positive ? '+' : '-'}${summary.balance}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Recent Transactions ({transactions.total})</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="overflow-x-auto">
                            <table className="w-full table-auto">
                                <thead>
                                    <tr className="border-b">
                                        <th className="text-left p-3">Transaction ID</th>
                                        <th className="text-left p-3">Type</th>
                                        <th className="text-left p-3">Description</th>
                                        <th className="text-left p-3">Amount</th>
                                        <th className="text-left p-3">Date</th>
                                        <th className="text-left p-3">Status</th>
                                        <th className="text-left p-3">Recorded By</th>
                                        <th className="text-left p-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {transactions.data.map((transaction) => (
                                        <tr key={transaction.id} className="border-b hover:bg-gray-50">
                                            <td className="p-3 font-mono text-sm">{transaction.transaction_id}</td>
                                            <td className="p-3">
                                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                    transaction.type === 'income' 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : 'bg-red-100 text-red-800'
                                                }`}>
                                                    {transaction.type}
                                                </span>
                                            </td>
                                            <td className="p-3">
                                                <div>
                                                    <div className="font-medium">{transaction.description}</div>
                                                    <div className="text-sm text-gray-500">{transaction.category}</div>
                                                </div>
                                            </td>
                                            <td className="p-3">
                                                <div className={`font-bold ${transaction.type === 'income' ? 'text-green-600' : 'text-red-600'}`}>
                                                    {transaction.type === 'income' ? '+' : '-'}${transaction.amount}
                                                </div>
                                            </td>
                                            <td className="p-3 text-sm">
                                                {new Date(transaction.transaction_date).toLocaleDateString()}
                                            </td>
                                            <td className="p-3">
                                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                    transaction.status === 'completed' 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : transaction.status === 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-gray-100 text-gray-800'
                                                }`}>
                                                    {transaction.status}
                                                </span>
                                            </td>
                                            <td className="p-3 text-sm">
                                                {transaction.employee 
                                                    ? `${transaction.employee.first_name} ${transaction.employee.last_name}`
                                                    : 'System'
                                                }
                                            </td>
                                            <td className="p-3">
                                                <div className="flex gap-2">
                                                    <Link href={`/finance/${transaction.id}`}>
                                                        <Button variant="outline" size="sm">View</Button>
                                                    </Link>
                                                    <Link href={`/finance/${transaction.id}/edit`}>
                                                        <Button variant="outline" size="sm">Edit</Button>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {transactions.data.length === 0 && (
                            <div className="text-center py-8 text-gray-500">
                                No transactions found. <Link href="/finance/create" className="text-blue-600 hover:underline">Add the first transaction</Link>.
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}