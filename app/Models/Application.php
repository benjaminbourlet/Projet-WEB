<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cv',
        'cover_letter',
        'offer_id',
        'user_id',
        'status_id',
    ];

    public $incrementing = false; // Désactive l'auto-incrémentation
    protected $primaryKey = null; // Laravel ne doit pas chercher un `id`
    /**
     * Relation avec la ville
     */

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
