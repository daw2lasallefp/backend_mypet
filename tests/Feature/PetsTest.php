<?php
namespace Tests\Feature;

use App\Models\Pets;
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
}
