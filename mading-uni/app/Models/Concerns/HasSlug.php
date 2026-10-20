<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->slugSourceField()) && ! $model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }

    protected function slugSourceField(): string
    {
        return property_exists($this, 'slugSource') ? $this->slugSource : 'title';
    }

    protected function slugField(): string
    {
        return property_exists($this, 'slugField') ? $this->slugField : 'slug';
    }

    public function generateUniqueSlug(): string
    {
        $source = $this->{$this->slugSourceField()} ?? '';
        $base = Str::slug($source);

        if (empty($base)) {
            $base = 'item';
        }

        $slug = $base;
        $i = 1;

        while ($this->slugExists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    protected function slugExists(string $slug): bool
    {
        $query = static::query()->where($this->slugField(), $slug);

        if ($this->exists) {
            $query->where('id', '!=', $this->getKey());
        }

        if (in_array('university_id', $this->getFillable(), true) ||
            array_key_exists('university_id', $this->getAttributes())) {
            if (! empty($this->university_id)) {
                $query->where('university_id', $this->university_id);
            }
        }

        return $query->exists();
    }
}