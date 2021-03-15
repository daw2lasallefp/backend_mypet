<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date_time', 
        'pet_id',
        'employee_id',
           
    ];
}
