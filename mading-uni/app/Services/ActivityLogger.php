<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log aktivitas umum.
     *
     * @param  string  $action  Contoh: 'post.created', 'university.updated'
     * @param  Model|null  $subject  Model yang jadi subjek
     * @param  array  $properties  Data tambahan (before/after)
     */
    public function log(string $action, ?Model $subject = null, array $properties = []): ActivityLog
    {
        $user = Auth::user();

        return ActivityLog::create([
            'user_id' => $user?->id,
            'university_id' => $user?->university_id,
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'properties' => $properties,
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 255),
        ]);
    }

    /**
     * Log untuk aksi create.
     */
    public function created(Model $subject, array $extra = []): ActivityLog
    {
        return $this->log(
            $this->actionName($subject, 'created'),
            $subject,
            array_merge(['after' => $subject->toArray()], $extra)
        );
    }

    /**
     * Log untuk aksi update.
     * Otomatis simpan before & after (hanya field yang berubah).
     */
    public function updated(Model $subject, array $before = [], array $extra = []): ActivityLog
    {
        $changes = [];
        foreach ($subject->getChanges() as $key => $newValue) {
            if ($key === 'updated_at') {
                continue;
            }
            $changes[$key] = [
                'before' => $before[$key] ?? null,
                'after' => $newValue,
            ];
        }

        return $this->log(
            $this->actionName($subject, 'updated'),
            $subject,
            array_merge(['changes' => $changes], $extra)
        );
    }

    /**
     * Log untuk aksi delete.
     */
    public function deleted(Model $subject, array $extra = []): ActivityLog
    {
        return $this->log(
            $this->actionName($subject, 'deleted'),
            $subject,
            array_merge(['before' => $subject->toArray()], $extra)
        );
    }

    /**
     * Log untuk custom action.
     */
    public function custom(string $action, ?Model $subject = null, array $properties = []): ActivityLog
    {
        return $this->log($action, $subject, $properties);
    }

    /**
     * Generate nama action dari class model.
     * Contoh: Post → 'post.created'
     */
    protected function actionName(Model $subject, string $verb): string
    {
        $class = class_basename($subject);

        return strtolower($class) . '.' . $verb;
    }
}