<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'region_id'
    ];
    
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function postalCodes()
    {
        return $this->belongsToMany(Postal_Code::class, 'cities_postals_codes', 'city_id', 'postal_code_id');
    }
    
}
