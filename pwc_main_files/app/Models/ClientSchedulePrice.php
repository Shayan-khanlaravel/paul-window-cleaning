<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSchedulePrice extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function clientPaymentPrice()
    {
        return $this->belongsTo(ClientPriceList::class,'price_id','id');
    }

}
