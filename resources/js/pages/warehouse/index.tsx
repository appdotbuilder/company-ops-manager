import React from 'react';
import { Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Heading from '@/components/heading';

interface WarehouseItem {
    id: number;
    item_code: string;
    name: string;
    description: string;
    category: string;
    quantity: number;
    min_quantity: number;
    unit_price: number;
    unit: string;
    location: string;
    supplier: string;
    status: string;
    is_low_stock: boolean;
    total_value: string;
}

interface Props {
    items: {
        data: WarehouseItem[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    lowStockCount: number;
    [key: string]: unknown;
}

export default function WarehouseIndex({ items, lowStockCount }: Props) {
    return (
        <AppShell>
            <div className="container mx-auto p-6">
                <div className="flex justify-between items-center mb-6">
                    <Heading title="📦 Warehouse Management" />
                    <Link href="/warehouse/create">
                        <Button>➕ Add New Item</Button>
                    </Link>
                </div>

                {lowStockCount > 0 && (
                    <div className="mb-6 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                        <div className="flex items-center">
                            <div className="text-orange-600 text-2xl mr-3">⚠️</div>
                            <div>
                                <h3 className="font-semibold text-orange-800">Low Stock Alert</h3>
                                <p className="text-orange-700">
                                    {lowStockCount} item{lowStockCount !== 1 ? 's' : ''} running low on stock and need restocking.
                                </p>
                            </div>
                        </div>
                    </div>
                )}

                <Card>
                    <CardHeader>
                        <CardTitle>Inventory Items ({items.total})</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="overflow-x-auto">
                            <table className="w-full table-auto">
                                <thead>
                                    <tr className="border-b">
                                        <th className="text-left p-3">Item Code</th>
                                        <th className="text-left p-3">Name</th>
                                        <th className="text-left p-3">Category</th>
                                        <th className="text-left p-3">Stock</th>
                                        <th className="text-left p-3">Unit Price</th>
                                        <th className="text-left p-3">Total Value</th>
                                        <th className="text-left p-3">Status</th>
                                        <th className="text-left p-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {items.data.map((item) => (
                                        <tr key={item.id} className={`border-b hover:bg-gray-50 ${item.is_low_stock ? 'bg-orange-25' : ''}`}>
                                            <td className="p-3 font-mono text-sm">{item.item_code}</td>
                                            <td className="p-3">
                                                <div>
                                                    <div className="font-medium">{item.name}</div>
                                                    {item.description && (
                                                        <div className="text-sm text-gray-500">{item.description}</div>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="p-3">{item.category}</td>
                                            <td className="p-3">
                                                <div className={item.is_low_stock ? 'text-orange-600 font-semibold' : ''}>
                                                    {item.quantity} {item.unit}
                                                    {item.is_low_stock && (
                                                        <div className="text-xs text-orange-500">Low stock!</div>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="p-3">${item.unit_price}</td>
                                            <td className="p-3 font-medium">${item.total_value}</td>
                                            <td className="p-3">
                                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                    item.status === 'active' 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : item.status === 'out_of_stock'
                                                        ? 'bg-red-100 text-red-800'
                                                        : 'bg-gray-100 text-gray-800'
                                                }`}>
                                                    {item.status.replace('_', ' ')}
                                                </span>
                                            </td>
                                            <td className="p-3">
                                                <div className="flex gap-2">
                                                    <Link href={`/warehouse/${item.id}`}>
                                                        <Button variant="outline" size="sm">View</Button>
                                                    </Link>
                                                    <Link href={`/warehouse/${item.id}/edit`}>
                                                        <Button variant="outline" size="sm">Edit</Button>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {items.data.length === 0 && (
                            <div className="text-center py-8 text-gray-500">
                                No warehouse items found. <Link href="/warehouse/create" className="text-blue-600 hover:underline">Add the first item</Link>.
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}