<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'month_name',
        'year',
        'week_number',
        'amount',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
