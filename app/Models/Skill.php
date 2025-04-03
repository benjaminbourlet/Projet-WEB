<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'offers_skills', 'skill_id', 'offer_id');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offers_skills', 'skill_id', 'offer_id');
    }
}
