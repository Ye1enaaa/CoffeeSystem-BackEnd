<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archived extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'customerName', 'phoneNum', 'address', 'date'];
}
