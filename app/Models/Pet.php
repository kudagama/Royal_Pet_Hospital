<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'owner_name',
        'owner_phone',
        'date_of_birth',
        'pet_category_id',
        'pet_breed_id',
        'description',
        'image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(PetCategory::class, 'pet_category_id');
    }

    public function breed()
    {
        return $this->belongsTo(PetBreed::class, 'pet_breed_id');
    }

    public function opdVisits()
    {
        return $this->hasMany(OpdVisit::class);
    }
}
