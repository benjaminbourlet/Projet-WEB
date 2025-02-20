<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'email',
        'password',
        'region_id',
        'city_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function region()
    {
        return $this->belongsTo(Region::class);
    }   

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
