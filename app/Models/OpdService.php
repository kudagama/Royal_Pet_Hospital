<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdService extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_visit_id',
        'service_title',
        'price',
        'description',
        'touch_panel_image',
    ];

    public function visit()
    {
        return $this->belongsTo(OpdVisit::class, 'opd_visit_id');
    }}
