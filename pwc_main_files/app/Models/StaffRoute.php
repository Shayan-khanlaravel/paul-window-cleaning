<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRoute extends Model
{
    use HasFactory;


    public function assignRoute()
    {
        return $this->HasMany(AssignRoute::class, 'route_id', 'id');
    }

    public function staffRoute()
    {
        return $this->HasMany(AssignRoute::class, 'route_id', 'id');
    }
    public function clientRoute()
    {
        return $this->HasMany(ClientRoute::class, 'route_id', 'id');
    }

    // Relationship with Timelog
    public function timelogs()
    {
        return $this->hasMany(Timelog::class, 'route_id', 'id');
    }
}
