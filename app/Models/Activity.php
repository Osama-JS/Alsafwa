<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_category_id',
        'slug',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'image',
        'video_url',
        'status',
        'order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order' => 'integer',
        'activity_category_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(ActivityCategory::class, 'activity_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
