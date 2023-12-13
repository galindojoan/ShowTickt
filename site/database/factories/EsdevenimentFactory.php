<?php

namespace Database\Factories;

use App\Models\Esdeveniment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EsdevenimentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Esdeveniment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->sentence,
            'dia' => $this->faker->date,
            'imatge' => $this->faker->imageUrl(),
            'preu' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}