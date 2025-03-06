<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offers_departments', 'department_id', 'offer_id');
    }
    
}
