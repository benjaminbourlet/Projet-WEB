<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

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
     * Relation avec la ville
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    /**
     * Fonction pour le carroussel des entreprises
     */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'company_id');
    }

    /**
     * Relation avec les secteurs
     */
    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'companies_sectors', 'company_id', 'sector_id');
    }

    /**
     * Relation avec les évaluations des utilisateurs
     */
    public function evaluations()
    {
        return $this->belongsToMany(User::class, 'evaluations', 'company_id', 'user_id')
                    ->withPivot('grade', 'comment', 'created_at')
                    ->withTimestamps();
    }
}
