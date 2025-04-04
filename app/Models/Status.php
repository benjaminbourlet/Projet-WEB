<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle Status représente un statut générique (ex : En attente, Accepté, Refusé)
class Status extends Model
{
    use HasFactory;

    // Déclare les attributs
    protected $fillable = [
        'name', // Nom du statut
    ];

    /**
     * Relation polymorphe many-to-many avec le modèle User.
     * Permet d'associer un ou plusieurs statuts à un ou plusieurs utilisateurs.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'statusable');
    }

    /**
     * Relation polymorphe many-to-many avec le modèle Offer.
     * Permet d'associer un ou plusieurs statuts à une ou plusieurs offres.
     */
    public function offers()
    {
        return $this->morphedByMany(Offer::class, 'statusable');
    }
}
