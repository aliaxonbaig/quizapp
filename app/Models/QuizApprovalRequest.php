<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_header_id',
        'user_id',
        'request_message',
        'status',
        'reviewed_by',
        'review_message',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function quizHeader(): BelongsTo
    {
        return $this->belongsTo(QuizHeader::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
