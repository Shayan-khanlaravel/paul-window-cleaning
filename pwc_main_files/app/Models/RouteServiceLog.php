<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteServiceLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    protected $fillable = [
        'route_id',
        'staff_id',
        'service_date',
        'start_time',
        'end_time',
        'total_hours',
        'notes',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    // Relationship with StaffRoute
    public function route()
    {
        return $this->belongsTo(StaffRoute::class, 'route_id', 'id');
    }

    // Relationship with User (Staff)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}

