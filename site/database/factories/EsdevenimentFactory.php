<?php

namespace Database\Factories;

use App\Models\Esdeveniment;
use App\Models\User;
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
            'nom' => $this->faker->name,
            'dia' => $this->faker->date,
            'imatge' => $this->faker->imageUrl(),
            'preu' => $this->faker->randomFloat(2, 10, 1000),
            'aforament' => $this->faker->randomNumber(3),
            'user_id' => User::factory(),
        ];
    }
}