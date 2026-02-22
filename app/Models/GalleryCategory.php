<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'status',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'status' => 'string',
    ];

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
