<?php

namespace App\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Filament\Models\Contracts\HasName;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'email_verified_at',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        $panelGetId = $panel->getId();

        return match($panelGetId) {
            'admin' => (auth()->user()->hasRole(['super_admin']) &&
                        // auth()->user()->email == 'salman@baig.com'  &&
                        // auth()->user()->is_admin &&
                        auth()->user()->is_active
                    ),
            'member' => (auth()->user()->hasAnyRole(['super_admin|user']) &&
                         auth()->user()->is_active
                        ),
        };

    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null ;
    }



    public function sections(): HasMany {
        return $this->hasMany(Section::class);
    }

    public function quotes(): HasMany {
        return $this->hasMany(Section::class);
    }

    public function certifications(): HasMany {
        return $this->hasMany(Section::class);
    }

    public function domains(): HasMany {
        return $this->hasMany(Section::class);
    }
    public function quizHeaders(): HasMany {
        return $this->hasMany(QuizHeader::class);
    }

    public function sections_owned(): BelongsToMany {
        return $this->belongsToMany(Section::class);
    }

    public function certifications_owned(): BelongsToMany {
        return $this->belongsToMany(Certification::class);
    }
}
