<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Suburb;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_visibility',
        'email',
        'password',
        'suburb_id',
        'country_visibility',
        'profile_banner',
        'image',
        'aboutus',
        'country_status',
        'ip',
        'agent',
        'updated_at',
        'status',
      	'dob',
        'dob_visibility',
        'city_visibility',
        'suburb_visibility',
        'firstname',
        'fname_visibility',
        'lastname',
        'lname_visibility',
        'password_otp',
      	'password_otp_expires_at',
      	'pending_password',
      	'temp_email',
      	'email_change_requested_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // public function suburb() {

    //     return $this->hasOne(Suburb::class, 'id', 'suburb_id');
    // }
    public function city()
    {
        return $this->belongsTo(City::class, 'suburb_id');
    }
    public function town()
    {
        return $this->belongsTo(Towns::class, 'suburb_id');
    }
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
  	public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function getProfileImageAttribute()
    {
        return $this->image ? asset($this->image) : asset('assets/images/no_pic.png');
    }
  	public function receivedNotifications()
    {
      return $this->belongsToMany(Notification::class, 'notification_user')->withPivot('read', 'read_at');
    }
}
