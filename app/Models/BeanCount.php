<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeanCount extends Model
{
    use HasFactory;
    protected $fillable = [
        'good',
        'bad',
        'kilograms'
    ];
}
