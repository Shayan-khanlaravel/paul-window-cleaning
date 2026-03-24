<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'client_id',
        'month',
        'week_month',
        'week',
        'start_date',
        'end_date',
        'payment_type',
        'note',
        'note_two',
        'note_type',
        'note_date',
        'note_week_no',
        'extra_work_price',
        'extra_work',
        'extra_work_price_id',
        'note_two',
        'status',
        'position',
        'is_increase',
        'staff_id',
        'priority'
    ];

    public function clientSchedulePrice()
    {
        return $this->hasMany(ClientSchedulePrice::class, 'schedule_id', 'id');
    }

    public function clientSchedulePayment()
    {
        return $this->hasOne(ClientPayment::class, 'schedule_id', 'id');
    }

    public function clientName()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function clientHour()
    {
        return $this->hasMany(ClientTime::class, 'client_id', 'client_id');
    }

    public function StaffName()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }


}
