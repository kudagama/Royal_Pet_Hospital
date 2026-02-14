<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_ref',
        'pet_id',
        'visit_date',
        'total_amount',
        'advance_amount',
        'status',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function services()
    {
        return $this->hasMany(OpdService::class);
    }}
