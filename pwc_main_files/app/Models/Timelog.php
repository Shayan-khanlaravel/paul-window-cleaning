<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Timelog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['route_id', 'schedule_id', 'staff_id', 'service_date', 'week', 'month', 'year', 'start_time', 'end_time', 'total_hours', 'notes'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function route()
    {
        return $this->belongsTo(StaffRoute::class, 'route_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
