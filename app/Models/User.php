<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;
    protected $primaryKey = 'username';
    protected $keyType = 'string';
    protected $table = 'users';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Override method untuk autentikasi dengan MD5
    public function validateCredentials(array $credentials)
    {
        $plain = $credentials['password'];
        $hashed = $this->getAuthPassword();
        return md5($plain) === $hashed;
    }

    // Mutator untuk password agar selalu di-hash dengan MD5
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = md5($value);
    }

    // Accessor untuk mendapatkan role
    public function getRoleAttribute($value)
    {
        return strtolower($value);
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
