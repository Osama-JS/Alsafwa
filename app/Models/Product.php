<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en',
        'description_ar', 'description_en',
        'slug', 'image',
        'price', 'discount',
        'agency_id',
        'status', 'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'order' => 'integer',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the final price after discount.
     */
    public function getFinalPriceAttribute()
    {
        if ($this->price && $this->discount) {
            return max(0, $this->price - $this->discount);
        }
        return $this->price;
    }
}
