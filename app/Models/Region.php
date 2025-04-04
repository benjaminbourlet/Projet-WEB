<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Le modèle Region représente une région (ex : région administrative en France)
class Region extends Model
{
    use HasFactory; // Active les factories pour les tests et le seeding

    // Déclare les attributs
    protected $fillable = ['name'];
}
