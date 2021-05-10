<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class VaccinationsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListVaccinations()
    {
        $vaccinationsMock = Mockery::mock('overload:App\Models\Vaccinations');
        $vaccinationsMock
            ->shouldReceive('all')
            ->withNoArgs()
            ->once()
            ->andReturn([]);


        $this->app->instance('overload:App\Models\Vaccinations', $vaccinationsMock);

        $response = $this->call('GET', 'api/vaccinations');

        $response
            ->assertStatus(200)
            ->assertJson([]);
    }
}
