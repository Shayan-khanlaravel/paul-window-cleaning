<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Admin-entered extra hours for a staff member's route within a semi-monthly
 * payroll period.
 *
 * Uniquely identified by: staff_id + route_id + period_start + period_end.
 * total_extra_amount is kept in sync with per_hour_amount * total_extra_hours
 * whenever either value is set (see boot()).
 */
class PayrollExtraHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'route_id',
        'period_start',
        'period_end',
        'per_hour_amount',
        'total_extra_hours',
        'total_extra_amount',
        'created_by',
    ];

    protected $casts = [
        'period_start'       => 'date',
        'period_end'         => 'date',
        'per_hour_amount'    => 'decimal:2',
        'total_extra_hours'  => 'decimal:2',
        'total_extra_amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::saving(function (PayrollExtraHour $extraHours) {
            $extraHours->total_extra_amount = $extraHours->per_hour_amount * $extraHours->total_extra_hours;
        });
    }

    public function route()
    {
        return $this->belongsTo(StaffRoute::class, 'route_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
