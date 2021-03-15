<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clients;
use App\Models\Clinics;
use App\Models\Consultations;
use App\Models\Dates;
use App\Models\Employees;
use App\Models\Pets;
use App\Models\Specialities;
use App\Models\Vaccinations;
use App\Models\Vaccines;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Specialities::factory(3)->create();
        Employees::factory(10)->create();
        Clients::factory(10)->create();
        Clinics::factory(10)->create();
        Pets::factory(10)->create();
        Dates::factory(10)->create();
        Consultations::factory(10)->create();
        Vaccines::factory(2)->create();
        Vaccinations::factory(10)->create();
    }
}
