<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle Classe représente une classe (ex: 1ère, Terminale, etc.)
class Classe extends Model
{
    use HasFactory; // Active les factories pour les tests et le seeding

    // Déclare les attributs
    protected $fillable = [
        'name' 
    ];
}
