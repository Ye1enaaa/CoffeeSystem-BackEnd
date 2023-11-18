<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Archived;
use App\Models\Status;
use App\Models\User;

class ArchivedStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'archived_status_histories';

    protected $fillable = [
        'customer_id',
        'status_id',
        'user_id',
        'customerName',
        'sorterName',
        'kiloOfBeans',
        'status'
    ];
    public function archiveHistory(){
        return $this->belongsTo(Archived::class);
    }
    public function archiveID(){
        return $this->belongsTo(User::class);
    }
}