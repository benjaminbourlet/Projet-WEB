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
        'classe_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation avec la ville
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Un étudiant appartient à une seule classe
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Un pilote peut gérer plusieurs classes
     */
    public function classesPilots()
    {
        return $this->belongsToMany(Classe::class, 'users_classes', 'user_id', 'classe_id');
    }

    /**
     * Un utilisateur peut postuler à plusieurs offres
     */
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'applications', 'user_id', 'offer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    /**
     * Liste de souhaits de l'utilisateur pour les offres
     */
    public function wishlists()
    {
        return $this->belongsToMany(Offer::class, 'wishlists', 'user_id', 'offer_id')->withTimestamps();
    }

    /**
     * Relation avec les évaluations des entreprises
     */
    public function evaluations()
    {
        return $this->belongsToMany(Company::class, 'evaluations', 'user_id', 'company_id')
                    ->withPivot('grade', 'comment', 'created_at')
                    ->withTimestamps();
    }
}
