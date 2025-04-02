<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'offers_skills', 'skill_id', 'offer_id');
    }
    
}
