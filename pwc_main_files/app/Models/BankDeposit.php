<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankDeposit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    protected $fillable = [
        'staff_id',
        'route_id',
        'deposit_date',
        'deposit_amount',
        'deposit_slip_number',
        'notes',
    ];

    protected $casts = [
        'deposit_date' => 'date',
        'deposit_amount' => 'decimal:2',
    ];

    // Relationship with User (Staff)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    // Relationship with StaffRoute (optional)
    public function route()
    {
        return $this->belongsTo(StaffRoute::class, 'route_id', 'id');
    }
}

