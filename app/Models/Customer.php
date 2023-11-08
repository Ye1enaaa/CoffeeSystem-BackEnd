<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ArchivedStatusHistory;
use App\Models\History;
use App\Models\Status;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'customerName',
        'phoneNum',
        //'kiloOfBeans',
        'address',
        'date'
    ];

    public function customer(){
        return $this->belongsTo(User::class);
    }

    public function history(){
        return $this->hasMany(History::class, 'customer_id');
    }

    public function customerId(){
        return $this->hasMany(Status::class, 'customer_id');
    }
}
