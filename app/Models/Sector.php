<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public function Companies()
    {
        return $this->belongsToMany(Company::class, 'companies_sectors', 'company_id', 'sector_id');
    }
    
}
