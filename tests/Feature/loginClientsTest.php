<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Clients;

class loginClientsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     
    public function testLoginClients()
    {
        $response = $this->postJson('/api/loginClients', ['email' => 'marta@gmail.com', 'password' => 'Marta1']);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

  public function testNoLoginClients()
    {
        $response = $this->postJson('/api/loginClients', ['email' => 'marta@gmail.com', 'password' => 'MArta321']);
        $response
            ->assertStatus(400)
            ->assertJson(['error' => 'Email y/o contraseña incorrectos']);
    }

    public function testListClients(){
        $response = $this->getJson('api/clientsList');
        $response
            ->assertStatus(200);
            
    }

   
    /*public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/
}
