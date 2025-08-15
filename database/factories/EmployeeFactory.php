<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Employee>
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => 'EMP-' . fake()->unique()->numberBetween(1000, 9999),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'department' => fake()->randomElement([
                'Human Resources',
                'Finance',
                'IT',
                'Marketing',
                'Operations',
                'Sales',
                'Customer Service'
            ]),
            'position' => fake()->randomElement([
                'Manager',
                'Senior Analyst',
                'Analyst',
                'Coordinator',
                'Specialist',
                'Associate',
                'Director'
            ]),
            'salary' => fake()->randomFloat(2, 30000, 120000),
            'hire_date' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(['active', 'inactive', 'terminated']),
            'address' => fake()->address(),
            'birth_date' => fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
        ];
    }

    /**
     * Indicate that the employee is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the employee is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}