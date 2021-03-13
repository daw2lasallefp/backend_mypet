<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'surname',
        'email',
        'password',
        'work_shift',
        'admin',
        'work_shift',
        'speciality_id',
    ];
}
