<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'explanation',
        'is_active',
        'sections_id',
        'user_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Section::class);
    }
}
