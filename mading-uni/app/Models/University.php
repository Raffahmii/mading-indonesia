<?php

namespace App\Models;

use App\Enums\UniversityStatus;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
        'description',
        'primary_color',
        'secondary_color',
        'city',
        'address',
        'website',
        'email',
        'phone',
        'status',
    ];

    protected $casts = [
        'status' => UniversityStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Slug generated dari name
    protected $slugSource = 'name';

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class)
            ->where('role', \App\Enums\UserRole::UNIVERSITY_ADMIN);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts(): HasMany
    {
        return $this->hasMany(Post::class)
            ->where('status', \App\Enums\PostStatus::PUBLISHED);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === UniversityStatus::ACTIVE;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Mendapatkan URL logo (atau placeholder).
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo_path && \Storage::disk('public')->exists($this->logo_path)) {
            return \Storage::disk('public')->url($this->logo_path);
        }

        return asset('images/placeholders/logo-default.png');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', UniversityStatus::ACTIVE);
    }
}