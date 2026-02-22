<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
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

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
