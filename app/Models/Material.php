<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'files',
        'user_id',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
