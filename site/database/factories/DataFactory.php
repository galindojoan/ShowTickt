<?php

namespace Database\Factories;

use App\Models\data;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Data>
 */
class DataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * 
     * @return array<string, mixed>
     */
    protected $model = data::class;
    public function definition(): array
    {
        return [
          'dia' => $this->faker->date,
          'hores' => $this->faker->time,
        ];
    }
}
