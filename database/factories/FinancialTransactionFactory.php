<?php

namespace Database\Factories;

use App\Models\FinancialTransaction;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialTransaction>
 */
class FinancialTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\FinancialTransaction>
     */
    protected $model = FinancialTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['income', 'expense']);
        
        return [
            'transaction_id' => 'TXN-' . fake()->unique()->numberBetween(100000, 999999),
            'type' => $type,
            'category' => $this->getCategory($type),
            'amount' => fake()->randomFloat(2, 10, 10000),
            'description' => fake()->sentence(),
            'reference' => fake()->optional()->numerify('REF-######'),
            'account' => fake()->randomElement(['Cash', 'Bank Account', 'Credit Card', 'Petty Cash']),
            'transaction_date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
            'payment_method' => fake()->randomElement(['Cash', 'Bank Transfer', 'Check', 'Credit Card', 'Debit Card']),
            'employee_id' => Employee::factory(),
        ];
    }

    /**
     * Get category based on transaction type.
     */
    protected function getCategory(string $type): string
    {
        if ($type === 'income') {
            return fake()->randomElement([
                'Sales Revenue',
                'Service Income',
                'Investment Income',
                'Other Income',
                'Refunds'
            ]);
        }

        return fake()->randomElement([
            'Office Supplies',
            'Travel Expenses',
            'Utilities',
            'Rent',
            'Equipment Purchase',
            'Marketing',
            'Professional Services',
            'Insurance',
            'Maintenance'
        ]);
    }

    /**
     * Indicate that the transaction is income.
     */
    public function income(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'income',
            'category' => $this->getCategory('income'),
        ]);
    }

    /**
     * Indicate that the transaction is expense.
     */
    public function expense(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'expense',
            'category' => $this->getCategory('expense'),
        ]);
    }

    /**
     * Indicate that the transaction is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
}