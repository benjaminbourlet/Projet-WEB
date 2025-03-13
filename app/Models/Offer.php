<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'salary',
        'company_id',
    ];


    public function departments()
    {
        return $this->belongsToMany(Department::class, 'offers_departments', 'offer_id', 'department_id');
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'offers_skills', 'offer_id', 'skill_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class, 'applications', 'offer_id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'offer_id', 'user_id')->withTimestamps();
    }
    
}
