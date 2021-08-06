<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizHeader extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
