<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_ar', 'title_en',
        'content_ar', 'content_en',
        'meta_title_ar', 'meta_title_en',
        'meta_description_ar', 'meta_description_en',
        'image',
        'status',
        'order',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
