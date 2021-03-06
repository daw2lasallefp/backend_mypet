<?php

namespace Database\Factories;

use App\Models\Specialities;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Specialities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' =>  $this->faker->unique()->numberBetween(1,200),
            'name'=> $this->faker->unique()->randomElement(['Cardiologia', 'Cirugia', 'Oftamologia', 'Oncologia', 'Dermatologia', 'Traumatologia', 'Medicina_interna']),
        ];
    }
}
