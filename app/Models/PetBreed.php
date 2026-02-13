<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBreed extends Model
{
    use HasFactory;

    protected $fillable = ['pet_category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(PetCategory::class, 'pet_category_id');
    }
}
