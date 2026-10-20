<?php

namespace App\Enums;

enum ReviewAction: string
{
    case SUBMITTED = 'submitted';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::SUBMITTED => 'Diajukan',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::PUBLISHED => 'Dipublikasikan',
            self::ARCHIVED => 'Diarsipkan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUBMITTED => 'yellow',
            self::APPROVED => 'blue',
            self::REJECTED => 'red',
            self::PUBLISHED => 'green',
            self::ARCHIVED => 'slate',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::SUBMITTED => 'send',
            self::APPROVED => 'check-circle',
            self::REJECTED => 'x-circle',
            self::PUBLISHED => 'globe',
            self::ARCHIVED => 'archive',
        };
    }

    public function requiresNote(): bool
    {
        return $this === self::REJECTED;
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