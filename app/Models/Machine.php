<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Machine extends Model
{
    use HasFactory;

    #protected $table = 'machines';
    protected $fillable = ['formattedId']; 
    public function user(){
        return $this->belongsTo(User::class, 'formattedId');
    }
}
