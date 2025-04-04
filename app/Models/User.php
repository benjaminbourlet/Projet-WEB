<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

// Le modèle User représente un utilisateur (ex : étudiant, employé, etc.)
class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    // Déclare les attributs
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

    // Attributs à masquer pour ne pas les exposer (ex : password, token)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Formatage des données lors de la récupération
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Stockage du mot de passe avec un hash
    ];

    /**
     * Relation avec la ville.
     * Un utilisateur appartient à une seule ville.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relation avec la classe.
     * Un utilisateur (étudiant) appartient à une seule classe.
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Relation avec les classes qu'un utilisateur (pilote) peut gérer.
     * Un utilisateur peut gérer plusieurs classes.
     */
    public function classesPilots()
    {
        return $this->belongsToMany(Classe::class, 'users_classes', 'user_id', 'classe_id');
    }

    /**
     * Relation avec les offres auxquelles l'utilisateur a postulé.
     * Un utilisateur peut postuler à plusieurs offres.
     */
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'applications', 'user_id', 'offer_id');
    }

    /**
     * Relation avec les candidatures de l'utilisateur.
     * Un utilisateur peut avoir plusieurs candidatures (applications).
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    /**
     * Relation avec la wishlist de l'utilisateur.
     * Un utilisateur peut avoir plusieurs offres dans sa wishlist.
     */
    public function wishlists()
    {
        return $this->belongsToMany(Offer::class, 'wishlists', 'user_id', 'offer_id')->withTimestamps();
    }

    /**
     * Relation avec les évaluations des entreprises.
     * Un utilisateur peut évaluer plusieurs entreprises.
     */
    public function evaluations()
    {
        return $this->belongsToMany(Company::class, 'evaluations', 'user_id', 'company_id')
                    ->withPivot('grade', 'comment', 'created_at')  // Champs supplémentaires dans la table pivot
                    ->withTimestamps();  // Enregistre les timestamps pour chaque évaluation
    }
}
