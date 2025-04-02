<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->morphedByMany(User::class, 'statusable');
    }

    public function offers()
    {
        return $this->morphedByMany(Offer::class, 'statusable');
    }
    
}
