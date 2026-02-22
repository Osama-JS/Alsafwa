<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'address_ar',
        'address_en',
        'phone',
        'email',
        'working_hours_ar',
        'working_hours_en',
        'latitude',
        'longitude',
        'status',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'status' => 'string',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
