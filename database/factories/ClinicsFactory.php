<?php

namespace Database\Factories;

use App\Models\Clinics;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClinicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clinics::class;

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
            'city'=> $this->faker->city,
            'address'=> $this->faker->address,
            'phone'=> $this->faker->phoneNumber,
            'email'=> $this->faker->unique()->safeEmail,
        ];
    }
}
