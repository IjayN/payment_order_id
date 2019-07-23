<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'phone', 'password', 'otp', 'avatar', 'admin', 'user', 'marketer', 'driver', 'student', 'validated', 'created_by', 'production', 'accountant'];

    protected $hidden = ['password', 'remember_token', 'otp',];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }

    public function assigned()
    {
        return $this->hasMany(Assigned::class, 'driver_id');
    }

    public function confirmation()
    {
        return $this->hasOne(Confirmation::class, 'driver_id');
    }

    public function remark()
    {
        return $this->hasMany(Remark::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

}
