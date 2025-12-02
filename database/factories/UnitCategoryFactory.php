<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitCategory>
 */
class UnitCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->lexify('UC-???')),
            'name' => $this->faker->word(),
            'count_index' => $this->faker->randomNumber(3),
            'years_depreciation' => $this->faker->numberBetween(3, 10),
        ];
    }
}
