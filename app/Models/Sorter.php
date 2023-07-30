<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Sorter extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'sorterName',
        'phoneNum',
        'address',
        'dateHired'
    ];
    public function sorter(){
        return $this->belongsTo(User::class);
    }
}
