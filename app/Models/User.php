<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory,HasRoles,Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'email',
        'password',
        'pp_path',
        'region_id',
        'city_id',
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

}
