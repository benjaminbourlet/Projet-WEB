<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle Sector représente un secteur d'activité (ex : Informatique, BTP, Santé, etc.)
class Sector extends Model
{
    use HasFactory; // Active les factories pour les tests/seeding

    // Déclare les attributs
    protected $fillable = [
        'name', // Nom du secteur
    ];
    
    /**
     * Relation avec les entreprises.
     * Un secteur peut regrouper plusieurs entreprises.
     * Table pivot : companies_sectors.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_sectors', 'sector_id', 'company_id');
    }
}
