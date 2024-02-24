<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Domain extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'details',
        'user_id',
        'is_active',
        'created_at',
        'updated_at',
        'section_id',
        'certification_id',
    ];

    public function section(): BelongsTo {
        return $this->belongsTo(Section::class);
    }

    public function certification(): BelongsTo {
        return $this->belongsTo(Certification::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany {
        return $this->hasMany(Question::class);

    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }
}
