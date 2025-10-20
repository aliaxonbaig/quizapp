<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
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
        'is_school_test',
        'test_date',
        'is_private',
        'is_student_created',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'domains' => 'array',
        'questions_taken' => 'array',
        'difficulty' => 'array',
        'approved_at' => 'datetime',
        'test_date' => 'datetime',
        'is_private' => 'boolean',
        'is_student_created' => 'boolean',
        'is_approved' => 'boolean',
        'is_school_test' => 'boolean',
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

    public function approvalRequests(): HasMany {
        return $this->hasMany(QuizApprovalRequest::class);
    }

    public function approver(): BelongsTo {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function classes(): BelongsToMany {
        return $this->belongsToMany(ClassModel::class, 'class_quiz_header');
    }
}
