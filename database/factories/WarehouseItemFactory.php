<?php

namespace Database\Factories;

use App\Models\WarehouseItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WarehouseItem>
 */
class WarehouseItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\WarehouseItem>
     */
    protected $model = WarehouseItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_code' => 'ITM-' . fake()->unique()->numberBetween(10000, 99999),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'category' => fake()->randomElement([
                'Electronics',
                'Office Supplies',
                'Furniture',
                'Tools',
                'Materials',
                'Equipment',
                'Consumables'
            ]),
            'quantity' => fake()->numberBetween(0, 500),
            'min_quantity' => fake()->numberBetween(5, 50),
            'unit_price' => fake()->randomFloat(2, 1, 1000),
            'unit' => fake()->randomElement(['pcs', 'kg', 'lbs', 'meters', 'liters', 'boxes']),
            'location' => fake()->randomElement(['A1-01', 'A1-02', 'B2-01', 'B2-02', 'C3-01', 'C3-02']),
            'supplier' => fake()->company(),
            'status' => fake()->randomElement(['active', 'discontinued', 'out_of_stock']),
        ];
    }

    /**
     * Indicate that the item is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the item has low stock.
     */
    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            $minQuantity = fake()->numberBetween(10, 20);
            return [
                'min_quantity' => $minQuantity,
                'quantity' => fake()->numberBetween(0, $minQuantity),
                'status' => 'active',
            ];
        });
    }
}