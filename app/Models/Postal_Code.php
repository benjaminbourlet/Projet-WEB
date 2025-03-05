<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postal_Code extends Model
{
    use HasFactory;

    protected $table = 'postals_codes';
    protected $fillable = [
        'num',
    ];

    public function cities()
    {
        return $this->belongsToMany(City::class, 'cities_postals_codes', 'postal_code_id', 'city_id');
    }    
    
}
