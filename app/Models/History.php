<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'customerName',
        'sorterName',
        'kiloOfBeans',
        'status',
        'date'
    ];

    public function history(){
        return $this->belongsTo(Customer::class);
    }

    public function histories(){
        return $this->belongsTo(User::class);
    }
}
