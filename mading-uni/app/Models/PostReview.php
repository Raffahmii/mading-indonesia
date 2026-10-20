<?php

namespace App\Models;

use App\Enums\ReviewAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostReview extends Model
{
    // Cuma pakai created_at, nggak ada updated_at
    public const UPDATED_AT = null;

    protected $fillable = [
        'post_id',
        'actor_id',
        'action',
        'note',
    ];

    protected $casts = [
        'action' => ReviewAction::class,
        'created_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isRejection(): bool
    {
        return $this->action === ReviewAction::REJECTED;
    }
}