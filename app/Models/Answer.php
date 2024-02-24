<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'is_checked',
        'question_id',
    ];

    public function question(): BelongsTo {
        return $this->belongsTo(Question::class);
    }
}
