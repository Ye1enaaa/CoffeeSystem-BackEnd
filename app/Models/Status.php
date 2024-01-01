<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ArchivedStatusHistory;
use App\Models\Customer;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'customerName',
        'sorterName',
        'kiloOfBeans',
        'badCount',
        'status'
    ];

    public function status(){
        return $this->belongsTo(User::class);
    }

    public function customerId(){
        return $this->belongsTo(Customer::class);
    }
}
