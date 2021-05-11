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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Specialities::factory(7)->create();
        Employees::factory(10)->create();
        Clients::factory(10)->create();
        Clinics::factory(10)->create();
        Pets::factory(10)->create();
        Dates::factory(10)->create();
        Consultations::factory(10)->create();
        Vaccines::factory(4)->create();
        Vaccinations::factory(10)->create();

        Employees::create(array(
            'name' => 'Admin',
            'surname' => 'Default',
            'email' => 'default@admin.com',
            'password' => Hash::make('Default_Admin1234'),
            'work_shift' => 'Tarde',
            'admin' => 1,
            'speciality_id' => DB::table('specialities')->pluck('id')->first(),
            'available' => 1
        ));
    }
}
