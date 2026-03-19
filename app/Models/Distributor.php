<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar', 'name_en',
        'address_ar', 'address_en',
        'description_ar', 'description_en',
        'url', 'phone', 'map_url', 'logo',
        'status', 'order',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
