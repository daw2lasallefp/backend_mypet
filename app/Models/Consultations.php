<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultations extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date_time',
        'comments',
        'pet_id',
        'employee_id',
    ];
}
