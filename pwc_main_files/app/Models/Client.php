<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $casts = [
        'is_child' => 'boolean',
        'client_type' => 'string',
        'payment_type' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function childClients()
    {
        return $this->hasMany(Client::class, 'parent_id', 'id')
            ->where('is_child', true);
    }

    public function parentClient()
    {
        return $this->belongsTo(Client::class, 'parent_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'client_id', 'id');
    }
    public function clientRoute()
    {
        return $this->belongsToMany(StaffRoute::class, 'client_routes', 'client_id', 'route_id');
    }
    public function clientWeek()
    {
        return $this->hasMany(AssignWeek::class, 'client_id', 'id');
    }
    public function weekSingle()
    {
        return $this->hasOne(AssignWeek::class, 'client_id', 'id');
    }
    public function clientDay()
    {
        return $this->hasMany(UnavailDay::class, 'client_id', 'id');
    }
    public function clientImage()
    {
        return $this->hasMany(ClientImage::class, 'client_id', 'id');
    }
    public function clientPrice()
    {
        return $this->hasMany(ClientPriceList::class, 'client_id', 'id');
    }

    public function clientSchedule()
    {
        return $this->hasMany(ClientSchedule::class, 'client_id', 'id');
    }
    public function clientHour()
    {
        return $this->hasMany(ClientTime::class, 'client_id', 'id');
    }
    public function clientRouteStaff()
    {
        return $this->hasMany(ClientRoute::class, 'client_id', 'id');
    }

    public function getFormattedPhoneAttribute()
    {
        if (!$this->contact_phone) {
            return '--';
        }

        $phone = preg_replace('/[^0-9]/', '', $this->contact_phone);

        if (strlen($phone) == 10) {
            return substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }

        return $this->contact_phone;
    }
}
