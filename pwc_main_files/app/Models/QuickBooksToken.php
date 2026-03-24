<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class QuickBooksToken extends Model
{
    use HasFactory;

    protected $table = 'quickbooks_tokens';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'access_token',
        'refresh_token',
        'realm_id',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Get the active token
     */
    public static function getActiveToken()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Check if token is expired or about to expire (within 5 minutes)
     */
    public function isExpired()
    {
        return $this->expires_at->lte(Carbon::now()->addMinutes(5));
    }

    /**
     * Check if token is valid
     */
    public function isValid()
    {
        return $this->is_active && !$this->isExpired();
    }
}
