<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Le modèle Application représente une candidature (CV, lettre de motivation, etc.)
class Application extends Model
{
    use HasFactory, SoftDeletes; // Active les factories et la suppression "douce" (soft delete)

    // Les attributs
    protected $fillable = [
        'cv',             
        'cover_letter',   
        'offer_id',       
        'user_id',       
        'status_id',      
    ];

    public $incrementing = false; // On désactive l'auto-incrémentation de la clé primaire

    protected $primaryKey = null; // On indique qu'il n'y a pas de clé primaire explicite (ou personnalisée)

    /**
     * Relation entre la candidature et l'offre d'emploi.
     * Une candidature appartient à une offre.
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Relation entre la candidature et l'utilisateur (candidat).
     * Une candidature appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation entre la candidature et son statut.
     * Une candidature a un statut (ex: en attente, validée, refusée).
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
