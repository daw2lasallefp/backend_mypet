<?php

namespace Database\Factories;

use App\Models\Vaccinations;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccinationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vaccinations::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1,200),
            'date' => $this->faker->dateTimeBetween('now', '+2year'),
            'done' => $this->faker->randomElement([true, false]),
            'pet_id' => \App\Models\Pets::inRandomOrder()->first()->id,
            'vaccine_id' => \App\Models\Vaccines::inRandomOrder()->first()->id,
            //
        ];
    }
}
