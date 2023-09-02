<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customerName',
        'sorterName',
        'kiloOfBeans',
        'status'
    ];

    public function status(){
        return $this->belongsTo(User::class);
    }
}
