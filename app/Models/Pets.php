<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'sex',
        'weight',
        'age',
        'species',
        'client_id',
        'breed',
    ];
}
