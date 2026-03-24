<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    //use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    // app/Models/User.php
    public function staffJobs()
    {
        return $this->hasMany(ClientSchedule::class, 'staff_id'); // 'staff_id' फॉरेन की है
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function client(){
        return $this->hasOne(Client::class);
    }
    public function userProfile(){
        return $this->hasMany(Profile::class);
    }
    public function staffRoute(){
        return $this->belongsToMany(StaffRoute::class,'assign_routes','staff_id','route_id');
    }
}
