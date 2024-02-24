<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
        'quiz_header_id',
        'certification_id',
        'domain_id',
        'question_id',
        'answer_id',
        'is_correct',
        'created_at',
        'updated_at',
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

    public function domain(): BelongsTo {
        return $this->belongsTo(Domain::class);
    }

    public function quiz_header(): BelongsTo {
        return $this->belongsTo(QuizHeader::class);
    }

    public function question(): BelongsTo {
        return $this->belongsTo(Question::class);
    }

}
