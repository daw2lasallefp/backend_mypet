<?php

namespace Database\Factories;

use App\Models\Consultations;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consultations::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1,200),
            'date_time' => $this->faker->dateTimeBetween('now', '+1year'),
            'comments' => $this->faker->sentence(20),
            'pet_id' => \App\Models\Pets::inRandomOrder()->first()->id,
            'employee_id' => \App\Models\Employees::inRandomOrder()->first()->id,
        ];
    }
}
