<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offers_departments', 'department_id', 'offer_id');
    }
    
}
