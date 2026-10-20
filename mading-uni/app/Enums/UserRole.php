<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case UNIVERSITY_ADMIN = 'university_admin';
    case MEMBER = 'member';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::UNIVERSITY_ADMIN => 'Admin Universitas',
            self::MEMBER => 'Anggota',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'purple',
            self::UNIVERSITY_ADMIN => 'blue',
            self::MEMBER => 'gray',
        };
    }

    public function isSuperAdmin(): bool
    {
        return $this === self::SUPER_ADMIN;
    }

    public function isUniversityAdmin(): bool
    {
        return $this === self::UNIVERSITY_ADMIN;
    }

    public function isMember(): bool
    {
        return $this === self::MEMBER;
    }

    public function canAccessAdminPanel(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::UNIVERSITY_ADMIN], true);
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