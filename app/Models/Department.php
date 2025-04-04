<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle Department représente un département (ex : département géographique ou administratif)
class Department extends Model
{
    use HasFactory; // Active les factories pour les tests et le seeding

    // Déclare les attributs
    protected $fillable = [
        'name', // Nom du département
    ];
    
    /**
     * Relation avec les offres.
     * Un département peut être associé à plusieurs offres.
     * Relation many-to-many via la table pivot 'offers_departments'.
     */
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offers_departments', 'department_id', 'offer_id');
    }
}
