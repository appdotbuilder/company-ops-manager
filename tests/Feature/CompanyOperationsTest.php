<?php

use App\Models\Employee;
use App\Models\WarehouseItem;
use App\Models\FinancialTransaction;
use App\Models\User;

it('displays dashboard on welcome page', function () {
    // Create some test data
    Employee::factory(5)->active()->create();
    WarehouseItem::factory(3)->active()->create();
    FinancialTransaction::factory(2)->completed()->create();

    $response = $this->get('/');
    
    $response->assertOk();
    $response->assertInertia(fn ($page) => 
        $page->component('welcome')
            ->has('employeeStats')
            ->has('warehouseStats')
            ->has('financeStats')
    );
});

it('allows authenticated users to access employees', function () {
    $user = User::factory()->create();
    
    Employee::factory(3)->create();
    
    $response = $this->actingAs($user)->get('/employees');
    
    $response->assertOk();
    $response->assertInertia(fn ($page) => 
        $page->component('employees/index')
            ->has('employees.data', 3)
    );
});

it('allows authenticated users to access warehouse', function () {
    $user = User::factory()->create();
    
    WarehouseItem::factory(3)->create();
    
    $response = $this->actingAs($user)->get('/warehouse');
    
    $response->assertOk();
    $response->assertInertia(fn ($page) => 
        $page->component('warehouse/index')
            ->has('items.data', 3)
    );
});

it('allows authenticated users to access finance', function () {
    $user = User::factory()->create();
    
    FinancialTransaction::factory(3)->create();
    
    $response = $this->actingAs($user)->get('/finance');
    
    $response->assertOk();
    $response->assertInertia(fn ($page) => 
        $page->component('finance/index')
            ->has('transactions.data', 3)
            ->has('summary')
    );
});

it('redirects guests to login for protected routes', function () {
    $this->get('/employees')->assertRedirect('/login');
    $this->get('/warehouse')->assertRedirect('/login');
    $this->get('/finance')->assertRedirect('/login');
});