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
class PetsTest extends TestCase {


    public function testListPets() {
        $petsMock = Mockery::mock('overload:App\Models\Pets');
        $petsMock
            ->shouldReceive('all')
            ->withNoArgs()
            ->once()
            ->andReturn([]);

        $this->app->instance('overload:App\Models\Pets', $petsMock);

        $response = $this->call('GET', 'api/pets');

        $response
            ->assertStatus(200)
            ->assertJson([]);
    }

    public function testListPet() {
        $petsMock = Mockery::mock('overload:App\Models\Pets');
        $petsMock
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn(["name" => "mascota", "sex" => "hembra", "weight" => 2, "age" => 3, "species" => "felino",
                "client_id" => 3]);

        $this->app->instance('overload:App\Models\Pets', $petsMock);

        $response = $this->call('GET', 'api/pets/1');

        $response
            ->assertStatus(200)
            ->assertJson(["name" => "mascota", "sex" => "hembra", "weight" => 2, "age" => 3, "species" => "felino",
                "client_id" => 3]);
    }
}
