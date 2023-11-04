<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Customer;
use App\Models\ArchivedStatusHistory;
use App\Models\Sorter;
use App\Models\Details;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function customer(){
        return $this->hasMany(Customer::class, 'user_id');
    }

    public function sorter(){
        return $this->hasMany(Sorter::class, 'user_id');
    }

    public function details(){
        return $this->hasMany(Details::class, 'user_id');
    }

    public function archiveID(){
        return $this->hasMany(ArchivedStatusHistory::class, 'user_id');
    }
}
