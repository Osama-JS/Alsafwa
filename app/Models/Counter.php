<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'value',
        'icon',
        'order',
        'status'
    ];
}
