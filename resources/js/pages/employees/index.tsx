import React from 'react';
import { Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Heading from '@/components/heading';

interface Employee {
    id: number;
    employee_id: string;
    first_name: string;
    last_name: string;
    email: string;
    phone: string;
    department: string;
    position: string;
    salary: number;
    hire_date: string;
    status: string;
}

interface Props {
    employees: {
        data: Employee[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    [key: string]: unknown;
}

export default function EmployeesIndex({ employees }: Props) {
    return (
        <AppShell>
            <div className="container mx-auto p-6">
                <div className="flex justify-between items-center mb-6">
                    <Heading title="👥 Employee Management" />
                    <Link href="/employees/create">
                        <Button>➕ Add New Employee</Button>
                    </Link>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>All Employees ({employees.total})</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="overflow-x-auto">
                            <table className="w-full table-auto">
                                <thead>
                                    <tr className="border-b">
                                        <th className="text-left p-3">Employee ID</th>
                                        <th className="text-left p-3">Name</th>
                                        <th className="text-left p-3">Department</th>
                                        <th className="text-left p-3">Position</th>
                                        <th className="text-left p-3">Status</th>
                                        <th className="text-left p-3">Hire Date</th>
                                        <th className="text-left p-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {employees.data.map((employee) => (
                                        <tr key={employee.id} className="border-b hover:bg-gray-50">
                                            <td className="p-3 font-mono text-sm">{employee.employee_id}</td>
                                            <td className="p-3">
                                                <div>
                                                    <div className="font-medium">{employee.first_name} {employee.last_name}</div>
                                                    <div className="text-sm text-gray-500">{employee.email}</div>
                                                </div>
                                            </td>
                                            <td className="p-3">{employee.department}</td>
                                            <td className="p-3">{employee.position}</td>
                                            <td className="p-3">
                                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                    employee.status === 'active' 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : employee.status === 'inactive'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-red-100 text-red-800'
                                                }`}>
                                                    {employee.status}
                                                </span>
                                            </td>
                                            <td className="p-3 text-sm">{new Date(employee.hire_date).toLocaleDateString()}</td>
                                            <td className="p-3">
                                                <div className="flex gap-2">
                                                    <Link href={`/employees/${employee.id}`}>
                                                        <Button variant="outline" size="sm">View</Button>
                                                    </Link>
                                                    <Link href={`/employees/${employee.id}/edit`}>
                                                        <Button variant="outline" size="sm">Edit</Button>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {employees.data.length === 0 && (
                            <div className="text-center py-8 text-gray-500">
                                No employees found. <Link href="/employees/create" className="text-blue-600 hover:underline">Add the first employee</Link>.
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}