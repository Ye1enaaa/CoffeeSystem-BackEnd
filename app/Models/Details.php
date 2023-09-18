<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profileAvatar',
        'images',
        'companyName',
        'companyNumber',
        'companyLocation',
    ];

    public function details(){
        return $this->belongsTo(User::class);
    }
}
