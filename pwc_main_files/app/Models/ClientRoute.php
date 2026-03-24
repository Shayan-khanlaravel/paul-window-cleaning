<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRoute extends Model
{
    use HasFactory;
    protected $guarded = [];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function clients()
    {
        return $this->HasMany(Client::class, 'id', 'client_id');
    }
    public function clientWeek()
    {
        return $this->hasMany(AssignWeek::class, 'client_id', 'client_id');
    }
    public function clientSchedule()
    {
        return $this->hasMany(ClientSchedule::class, 'client_id', 'client_id');
    }

    public function route()
    {
        return $this->belongsTo(StaffRoute::class, 'route_id', 'id');
    }
}
