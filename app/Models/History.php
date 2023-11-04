<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sorterName',
        'kiloOfBeans',
        'status',
        'date'
    ];

    public function history(){
        return $this->belongsTo(Customer::class);
    }
}
