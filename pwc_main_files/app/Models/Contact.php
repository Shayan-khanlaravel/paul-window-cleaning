<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    protected $guarded= [];
    use SoftDeletes;


    public function contactSiding(){
        return $this->HasMany(ContactCleaning::class,'contact_id','id');
    }
    public function contactWashing(){
        return $this->HasMany(ContactSiding::class,'contact_id','id');
    }
    public function contactImage(){
        return $this->HasMany(ContactImage::class,'contact_id','id');
    }
}
