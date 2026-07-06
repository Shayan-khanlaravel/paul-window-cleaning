<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Semi-monthly payroll bonus
 *
 * A bonus is uniquely identified by: staff_id + route_id + year + month_name + week_number.
 *
 * NOTE ON COLUMN SEMANTICS (changed with the semi-monthly revamp):
 *   - month_name : plain calendar month, e.g. "January"  (was "January - February")
 *   - week_number: the semi-monthly half -> 1 = 1st-15th, 2 = 16th-EOM  (was week 1-4)
 * Column names are kept as-is to avoid a schema/doctrine-dbal migration; only the
 * stored values changed. See App\Support\PayrollPeriod for all period math.
 */
class PayrollBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'route_id',
        'month_name',
        'year',
        'week_number',
        'amount',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function route()
    {
        return $this->belongsTo(StaffRoute::class, 'route_id');
    }
}
