<?php

namespace Tests\Feature;

use App\Models\Employees;
use Tests\TestCase;
use Mockery;



class EmployeeTest extends TestCase
{

    public function testLoginEmployees()
    {
        $response = $this->postJson('/api/loginEmployee', ['email' => 'default@admin.com', 'password' => 'Default_Admin1234']);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testBadLoginEmployees()
    {
        $response = $this->postJson('/api/loginEmployee', ['email' => 'default@admin.com', 'password' => '123456A']);
        $response
            ->assertStatus(400)
            ->assertJson(['error' => 'Email y/o contraseña incorrectos']);
    }

    public function testRegisterEmployees()
    {
        //Modificar id de la especialidad a una existente en la BD
        $response = $this->postJson('api/registerEmployee', [
            'name' => 'Laura',
            'surname' => 'Checa',
            'email' => 'nuevoemail@hotmail.com',
            'password' => 'uuuuuAa',
            'workShifts' => 'tarde',
            'admin' => '0',
            'specialities' => '77',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'surname',
                'email',
                'password',
                'work_shift',
                'speciality_id',
                'created_at',
                'updated_at',
                'id',
                'admin'
            ]);
    }

    public function testRegisterEmployeesExitingEmail()
    {
        $response = $this->postJson('api/registerEmployee', [
            'name' => 'Laura',
            'surname' => 'Checa',
            'email' => 'default@admin.com',
            'password' => 'uuuuuAa',
            'workShifts' => 'tarde',
            'admin' => '0',
            'specialities' => '12',
        ]);

        $response->assertStatus(409);
    }

    public function testGetEmployees()
    {
        $employee = Employees::where('email', 'default@admin.com')->first();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($employee);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('api/employees');

        $response->assertStatus(200);
    }

    public function testGetEmployeesNoToken()
    {
        $employee = Employees::where('email', 'default@admin.com')->first();

        $response = $this->withHeaders(['Authorization' => 'Bearer ey'])->get('api/employees');

        $response
            ->assertStatus(403)
            ->assertJson(['status' => 'Token is Invalid']);
    }
}
