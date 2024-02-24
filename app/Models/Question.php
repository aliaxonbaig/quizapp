<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Question extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'question',
        'explanation',
        'is_active',
        'level',
        'question_id',
        'user_id',
        'section_id',
        'certification_id',
        'domain_id',
        'created_at',
        'updated_at',
    ];

    public function section(): BelongsTo {
        return $this->belongsTo(Section::class);
    }

    public function certification(): BelongsTo {
        return $this->belongsTo(Certification::class);
    }

    public function domain(): BelongsTo {
        return $this->belongsTo(Domain::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany {
        return $this->hasMany(Answer::class);

    }

    public function quizzes(): HasMany {
        return $this->hasMany(Quiz::class);

    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

}
