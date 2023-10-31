<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedStatusHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'user_id',
        'customerName',
        'sorterName',
        'kiloOfBeans',
        'status'
    ];
}
