<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ClinicsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListClinics()
    {
        $clinicsMock = Mockery::mock('overload:App\Models\Clinics');
        $clinicsMock
            ->shouldReceive('all')
            ->withNoArgs()
            ->once()
            ->andReturn([]);


        $this->app->instance('overload:App\Models\Clinics', $clinicsMock);

        $response = $this->call('GET', 'api/clinics');

        $response
            ->assertStatus(200)
            ->assertJson([]);
    }
}
