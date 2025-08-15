<?php

use App\Models\Employee;
use App\Models\User;

it('can create employee', function () {
    $user = User::factory()->create();
    
    $employeeData = [
        'employee_id' => 'EMP-001',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@company.com',
        'phone' => '555-0123',
        'department' => 'IT',
        'position' => 'Developer',
        'salary' => 75000,
        'hire_date' => '2024-01-15',
        'status' => 'active',
        'address' => '123 Main St',
        'birth_date' => '1990-05-15',
    ];
    
    $response = $this->actingAs($user)->post('/employees', $employeeData);
    
    expect(Employee::where('employee_id', 'EMP-001')->exists())->toBeTrue();
    expect(Employee::where('email', 'john.doe@company.com')->exists())->toBeTrue();
    
    $employee = Employee::where('employee_id', 'EMP-001')->first();
    $response->assertRedirect("/employees/{$employee->id}");
});

it('validates employee data', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/employees', []);
    
    $response->assertSessionHasErrors([
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'department',
        'position',
        'salary',
        'hire_date',
        'status',
    ]);
});

it('can update employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    
    $updateData = [
        'employee_id' => $employee->employee_id,
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@company.com',
        'phone' => '555-0456',
        'department' => 'Marketing',
        'position' => 'Manager',
        'salary' => 85000,
        'hire_date' => $employee->hire_date->format('Y-m-d'),
        'status' => 'active',
        'address' => '456 Oak Ave',
        'birth_date' => '1985-03-20',
    ];
    
    $response = $this->actingAs($user)->put("/employees/{$employee->id}", $updateData);
    
    expect(Employee::where([
        'id' => $employee->id,
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'department' => 'Marketing',
    ])->exists())->toBeTrue();
    
    $response->assertRedirect("/employees/{$employee->id}");
});