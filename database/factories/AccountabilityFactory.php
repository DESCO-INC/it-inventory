<?php

namespace Database\Factories;

use App\Models\Accountability;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accountability>
 */
class AccountabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Accountability::class;
    public function definition(): array
    {
        return [
            'inventory_id' => Inventory::factory(),
            'name' => $this->faker->name(),
            'department' => $this->faker->randomElement([
                'Finance',
                'HR',
                'IT',
                'Logistics',
                'Maintenance',
                'Operations',
                'Procurement',
            ]),
            'location' => $this->faker->randomElement([
                'Head Office',
                'Warehouse',
                'Site A',
                'Site B',
                'Remote',
            ]),
            'date_received' => $this->faker->date('Y-m-d', 'now'),
            'date_returned' => $this->faker->optional()->date('Y-m-d', '+1 year'),
            'returned_to' => $this->faker->name(),
            'created_by' => $this->faker->name(),
        ];
    }
}
