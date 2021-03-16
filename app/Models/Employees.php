<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employees extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'surname',
        'email',
        'password',
        'admin',
        'work_shift',
        'speciality_id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
