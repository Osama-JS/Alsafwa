<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status', // new, read, replied
        'replied_at',
        'replied_by'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}
