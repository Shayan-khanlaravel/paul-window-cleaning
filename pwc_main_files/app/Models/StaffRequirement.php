<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRequirement extends Model
{
    use HasFactory;
    protected $guarded= [];
    public function staffRequirement(){
        return $this->belongsTo(User::class,'staff_id','id');
    }
}
