<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
        'certification_id',
        'domains',
        'completed',
        'quiz_size',
        'questions_taken',
        'score',
        'created_at',
        'updated_at',
        'difficulty',
        'learningmode',
    ];

    protected $casts = [
        'domains' => 'array',
        'questions_taken' => 'array',
        'difficulty' => 'array',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function section(): BelongsTo {
        return $this->belongsTo(Section::class);
    }
    public function certification(): BelongsTo {
        return $this->belongsTo(Certification::class);
    }

    public function quizzes(): HasMany {
        return $this->hasMany(Quiz::class);
    }
}
