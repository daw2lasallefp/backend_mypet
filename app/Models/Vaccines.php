<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccines extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'available'
    ];

    protected $casts = [
        'available' => 'boolean',
    ];
}
