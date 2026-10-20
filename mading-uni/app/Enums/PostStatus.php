<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Menunggu Review',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::PUBLISHED => 'Dipublikasikan',
            self::ARCHIVED => 'Diarsipkan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PENDING => 'yellow',
            self::APPROVED => 'blue',
            self::REJECTED => 'red',
            self::PUBLISHED => 'green',
            self::ARCHIVED => 'slate',
        };
    }

    public function isPubliclyVisible(): bool
    {
        return $this === self::PUBLISHED;
    }

    public function isEditable(): bool
    {
        return in_array($this, [self::DRAFT, self::REJECTED], true);
    }

    public function canBeSubmitted(): bool
    {
        return in_array($this, [self::DRAFT, self::REJECTED], true);
    }

    public function canBeReviewed(): bool
    {
        return $this === self::PENDING;
    }

    public function canBePublished(): bool
    {
        return $this === self::APPROVED;
    }

    public function isFinal(): bool
    {
        return in_array($this, [self::PUBLISHED, self::ARCHIVED], true);
    }

    /**
     * Transisi status yang diizinkan.
     * Format: [dari => [ke, ke, ...]]
     */
    public static function transitions(): array
    {
        return [
            self::DRAFT->value => [self::PENDING->value, self::ARCHIVED->value],
            self::PENDING->value => [self::APPROVED->value, self::REJECTED->value],
            self::APPROVED->value => [self::PUBLISHED->value, self::ARCHIVED->value],
            self::REJECTED->value => [self::DRAFT->value, self::ARCHIVED->value],
            self::PUBLISHED->value => [self::ARCHIVED->value],
            self::ARCHIVED->value => [],
        ];
    }

    public function canTransitionTo(self $target): bool
    {
        $allowed = self::transitions()[$this->value] ?? [];
        return in_array($target->value, $allowed, true);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSelectOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->label(),
        ])->toArray();
    }
}
