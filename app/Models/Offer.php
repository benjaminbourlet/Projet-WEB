<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Le modèle Offer représente une offre d’emploi ou de stage
class Offer extends Model
{
    use HasFactory, SoftDeletes; // Factories pour les tests + SoftDeletes pour une suppression "logique"

    // Déclare les attributs
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'salary',
        'company_id',
    ];

    /**
     * Relation avec les départements.
     * Une offre peut être disponible dans plusieurs départements.
     * Relation many-to-many via 'offers_departments'.
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'offers_departments', 'offer_id', 'department_id');
    }

    /**
     * Relation avec les compétences requises.
     * Une offre peut demander plusieurs compétences.
     * Relation many-to-many via 'offers_skills'.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'offers_skills', 'offer_id', 'skill_id');
    }

    /**
     * Relation avec l'entreprise.
     * Une offre appartient à une entreprise.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation avec les utilisateurs qui ont postulé.
     * Utilisée à travers la table 'applications'.
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'applications', 'offer_id', 'user_id');
    }

    /**
     * Relation avec les utilisateurs qui ont ajouté l’offre à leur wishlist.
     * Utilisée à travers la table 'wishlists'.
     * On active la gestion automatique des timestamps.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'offer_id', 'user_id')->withTimestamps();
    }
}
