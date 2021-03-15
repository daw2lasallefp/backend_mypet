<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccinations extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'done',
        'pet_id',
        'vaccine_id',
       
    ];
}
