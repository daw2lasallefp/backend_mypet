<?php
namespace Tests\Feature;

use App\Models\Vaccines;
use Closure;
use Illuminate\Support\Facades\App;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class VaccinesTest extends TestCase {


    public function testListVaccines() {
        $vaccinesMock = Mockery::mock('overload:App\Models\Vaccines');
        $vaccinesMock
            ->shouldReceive('all')
            ->withNoArgs()
            ->once()
            ->andReturn([]);


        $this->app->instance('overload:App\Models\Vaccines', $vaccinesMock);

        $response = $this->call('GET', 'api/vaccines');

        $response
            ->assertStatus(200)
            ->assertJson([]);
    }
    public function testListVaccine() {
        $vaccinesMock = Mockery::mock('overload:App\Models\Vaccines');
        $vaccinesMock
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn(["name" => "vacuna"]);


        $this->app->instance('overload:App\Models\Vaccines', $vaccinesMock);

        $response = $this->call('GET', 'api/vaccines/1');

        $response
            ->assertStatus(200)
            ->assertJson(["name" => "vacuna"]);
    }
}
