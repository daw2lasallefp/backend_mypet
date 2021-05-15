<?php

namespace Database\Factories;

use App\Models\Pets;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pets::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1,200),
            'name'=> $this->faker->name,
            'sex'=> $this->faker->randomElement(['male','female']),
            'weight'=> $this->faker->numberBetween(1,40),
            'age'=> $this->faker->numberBetween(0,20),
            'species'=> $this->faker->randomElement(['canine','feline']),
            'client_id' => \App\Models\Clients::inRandomOrder()->first()->id,
            'breed'=> $this->faker->randomElement(['pastor_aleman','border_collie','siames','labrador','persa', 'exotico']),

            //
        ];
    }
}
