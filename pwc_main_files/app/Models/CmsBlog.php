<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsBlog extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function blogImage(){
        return $this->HasMany(BlogAttachment::class,'blog_id','id');
    }
}
