<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeanData extends Model
{
    use HasFactory;

    protected $fillable = [
        'machineID',
        'bad'
    ];
}
