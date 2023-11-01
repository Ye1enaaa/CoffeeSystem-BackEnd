<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ArchivedStatusHistory;
use App\Models\User;

class Archived extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'user_id', 'customerName', 'phoneNum', 'address', 'date'];

    public function archiveHistory(){
        return $this->hasMany(ArchivedStatusHistory::class, 'customer_id');
    }

    public function customer(){
        return $this->belongsTo(User::class);
    }
}