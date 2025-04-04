<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle City représente une ville dans ta base de données
class City extends Model
{
    use HasFactory; // Permet l'utilisation des "factories" pour les tests et le seeding

    // Les attributs de la table
    protected $fillable = [
        'name',        
        'region_id'   
    ];
    
    /**
     * Relation entre la ville et la région.
     * Une ville appartient à une seule région.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

}
