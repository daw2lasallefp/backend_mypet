<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class DatesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListDates()
    {
        $datesMock = Mockery::mock('overload:App\Models\Dates');
        $datesMock
            ->shouldReceive('all')
            ->withNoArgs()
            ->once()
            ->andReturn([]);


        $this->app->instance('overload:App\Models\Dates', $datesMock);

        $response = $this->call('GET', 'api/dates');

        $response
            ->assertStatus(200)
            ->assertJson([]);
    }
}
