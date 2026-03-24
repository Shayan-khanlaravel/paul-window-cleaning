<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Profile extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];

    //    protected $fillable = [
    //        'user_id', 'bio', 'gender','dob','age','pic','country','state','city','address','postal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_roles()
    {
        return $this->belongsTo(Role::class);
    }

    public function getAdditionalEmailsAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function getAdditionalPhonesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function getAdditionalNamesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function getAdditionalPositionsAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function getAdditionalNotesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function getInvoiceEmailAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }
}
