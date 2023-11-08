<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateKeys extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'special_key',
    ];

    public function keys(){
        return $this->belongsTo(User::class);
    }
}
