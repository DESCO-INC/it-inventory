<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\UnitCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    protected $model = Inventory::class;
    public function definition(): array
    {
        return [
            'control_no' => strtoupper($this->faker->bothify('INV-#####')),
            'unit_category_id' => UnitCategory::factory(), // automatically create a related UnitCategory
            'model_name' => $this->faker->word(),
            'serial' => $this->faker->word(),
            'purchase_no' => strtoupper($this->faker->bothify('PO-#####')),
            'purchase_date' => $this->faker->date(),
            'manufacturing_date' => $this->faker->date(),
            'depreciation_date' => $this->faker->date(),
            'remarks' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'disposed']),
            'created_by' => $this->faker->name(),
        ];
    }
}
