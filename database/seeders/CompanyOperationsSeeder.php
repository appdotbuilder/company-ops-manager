<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\WarehouseItem;
use App\Models\FinancialTransaction;
use Illuminate\Database\Seeder;

class CompanyOperationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create employees
        $employees = Employee::factory(25)->active()->create();
        Employee::factory(5)->inactive()->create();

        // Create warehouse items
        WarehouseItem::factory(50)->active()->create();
        WarehouseItem::factory(10)->lowStock()->create();
        WarehouseItem::factory(5)->create(['status' => 'discontinued']);

        // Create financial transactions
        FinancialTransaction::factory(100)
            ->completed()
            ->recycle($employees)
            ->create();
            
        FinancialTransaction::factory(20)
            ->income()
            ->completed()
            ->recycle($employees)
            ->create();
            
        FinancialTransaction::factory(15)
            ->state(['status' => 'pending'])
            ->recycle($employees)
            ->create();
    }
}