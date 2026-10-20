<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Models\Concerns\BelongsToUniversity;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToUniversity;  // <- global scope + auto-fill university_id
    use HasSlug;

    protected $fillable = [
        'university_id',
        'category_id',
        'author_id',
        'reviewed_by',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image_path',
        'event_start',
        'event_end',
        'location',
        'status',
        'submitted_at',
        'reviewed_at',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'event_start' => 'datetime',
        'event_end' => 'datetime',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Slug dari title
    protected $slugSource = 'title';

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    | university() sudah otomatis dari trait BelongsToUniversity
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PostReview::class)->latest();
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', PostStatus::PENDING);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', PostStatus::DRAFT);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereNotNull('event_start')
            ->where('event_start', '>=', now())
            ->orderBy('event_start');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isPublished(): bool
    {
        return $this->status === PostStatus::PUBLISHED;
    }

    public function isPending(): bool
    {
        return $this->status === PostStatus::PENDING;
    }

    public function isDraft(): bool
    {
        return $this->status === PostStatus::DRAFT;
    }

    public function isEditable(): bool
    {
        return $this->status->isEditable();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image_path && \Storage::disk('public')->exists($this->cover_image_path)) {
            return \Storage::disk('public')->url($this->cover_image_path);
        }

        return asset('images/placeholders/cover-default.png');
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }
}