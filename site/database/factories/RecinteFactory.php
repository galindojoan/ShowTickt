<?php

// database/factories/RecinteFactory.php

namespace Database\Factories;

use App\Models\Recinte;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecinteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recinte::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'lloc' => $this->faker->city,
        ];
    }
}
