<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'email',
        'password',
        'pp_path',
        'birthdate',
        'city_id',
        'classe_id', // Un étudiant a une seule classe
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Un étudiant appartient à une seule classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Un pilote peut gérer plusieurs classes
    public function classesPilots()
    {
        return $this->belongsToMany(Classe::class, 'users_classes', 'user_id', 'classe_id');
    }
}
