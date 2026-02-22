<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_category_id',
        'title_ar',
        'title_en',
        'image',
        'status',
        'order',
        'created_by',
    ];

    protected $casts = [
        'order' => 'integer',
        'gallery_category_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
