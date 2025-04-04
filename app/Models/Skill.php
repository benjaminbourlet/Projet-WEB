<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle Skill représente une compétence (ex : PHP, Photoshop, Communication)
class Skill extends Model
{
    use HasFactory; // Active les factories pour générer des données de test

    // Déclare les attributs
    protected $fillable = [
        'name', // Nom de la compétence
    ];
    
    /**
     * Relation avec les offres.
     * Une compétence peut être liée à plusieurs offres.
     * Table pivot : offers_skills.
     */
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offers_skills', 'skill_id', 'offer_id');
    }

    /**
     * Une compétence est liée à une offre, pas directement à une entreprise.
     * À supprimer ou à modifier selon ton architecture.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'offers_skills', 'skill_id', 'offer_id');
    }
}
