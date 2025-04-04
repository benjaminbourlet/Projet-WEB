<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Le modèle Company représente une entreprise
class Company extends Model
{
    use HasFactory, SoftDeletes; // Active les factories et la suppression "douce" (soft deletes)

        // Déclare les attributs
    protected $fillable = [
        'name',
        'description',
        'email',
        'logo_path',
        'tel_number',
        'city_id',
        'address',
        'siret',
    ];

    /**
     * Relation avec la ville.
     * Une entreprise appartient à une ville.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relation avec les offres.
     * Une entreprise peut publier plusieurs offres.
     * Utilisé ici probablement pour un carrousel ou une liste d’offres liées à l’entreprise.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'company_id');
    }

    /**
     * Relation avec les secteurs d'activité.
     * Une entreprise peut appartenir à plusieurs secteurs.
     * Table pivot : companies_sectors.
     */
    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'companies_sectors', 'company_id', 'sector_id');
    }

    /**
     * Relation avec les évaluations.
     * Une entreprise peut être évaluée par plusieurs utilisateurs.
     * Les évaluations sont stockées dans une table pivot avec note, commentaire et date.
     */
    public function evaluations()
    {
        return $this->belongsToMany(User::class, 'evaluations', 'company_id', 'user_id')
                    ->withPivot('grade', 'comment', 'created_at') // Champs supplémentaires dans la table pivot
                    ->withTimestamps(); // Gère les timestamps dans la table pivot (created_at, updated_at)
    }
}