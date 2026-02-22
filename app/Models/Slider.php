<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en',
        'subtitle_ar', 'subtitle_en',
        'image',
        'link',
        'button_text_ar', 'button_text_en',
        'duration',
        'status',
        'order'
    ];

    protected $casts = [
        'order' => 'integer',
        'duration' => 'integer'
    ];

    // Accessors for button text based on locale
    public function getButtonTextAttribute()
    {
        return $this->{'button_text_' . app()->getLocale()};
    }
}
