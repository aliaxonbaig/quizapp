<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'test_date',
        'test_time',
        'certification_id',
        'domains',
        'is_active',
    ];

    protected $casts = [
        'test_date' => 'date',
        'test_time' => 'datetime',
        'domains' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the teacher who created this class
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the certification for this class
     */
    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Get all quiz headers associated with this class
     */
    public function quizHeaders(): BelongsToMany
    {
        return $this->belongsToMany(QuizHeader::class, 'class_quiz_header');
    }

    /**
     * Get the average score for this class
     */
    public function getAverageScoreAttribute(): float
    {
        return $this->quizHeaders()->avg('score') ?? 0;
    }

    /**
     * Get the number of students who took tests in this class
     */
    public function getStudentCountAttribute(): int
    {
        return $this->quizHeaders()
            ->distinct('user_id')
            ->count('user_id');
    }

    /**
     * Get all students who participated in this class
     */
    public function students()
    {
        return User::whereIn('id', $this->quizHeaders()->distinct()->pluck('user_id'))->get();
    }
}
