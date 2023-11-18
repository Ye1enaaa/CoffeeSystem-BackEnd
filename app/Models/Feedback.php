<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'companyName',
        'phoneNum',
        'coffee_bean_ai_sorter',
        'website',
        'message',
        'email',
        'status'
    ];

    protected $casts = [
        'coffee_bean_ai_sorter' => 'boolean',
        'website' => 'boolean',
    ];
}
