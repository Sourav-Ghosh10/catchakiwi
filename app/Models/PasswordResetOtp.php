<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetOtp extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_reset_otps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if the OTP has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Generate a random 6-digit OTP
     */
    public static function generateOtp(): string
    {
        // Generate random number between 0 and 999999
        $otp = random_int(0, 999999);

        // Pad with leading zeros to make it 6 digits
        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Scope a query to only include expired OTPs
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', Carbon::now());
    }

    /**
     * Scope a query to only include valid (non-expired) OTPs
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', Carbon::now());
    }

    /**
     * Get the user associated with this OTP
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Delete all expired OTPs (can be used in scheduled task)
     *
     * @return int Number of deleted records
     */
    public static function deleteExpired(): int
    {
        return self::expired()->delete();
    }
}
