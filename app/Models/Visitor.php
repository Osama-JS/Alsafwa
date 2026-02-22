<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_url',
        'referer',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}
