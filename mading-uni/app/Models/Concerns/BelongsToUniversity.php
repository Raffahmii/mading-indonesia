<?php

namespace App\Models\Concerns;

use App\Models\Scopes\UniversityScope;
use App\Models\University;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUniversity
{
    public static function bootBelongsToUniversity(): void
    {
        static::addGlobalScope(new UniversityScope());

        static::creating(function ($model) {
            if (empty($model->university_id)) {
                $user = auth()->user();

                if ($user && $user->university_id) {
                    $model->university_id = $user->university_id;
                }
            }
        });
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}