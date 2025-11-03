<?php

namespace App\Enums;

enum ActiveStatus: int
{
    case active = 1;
    case inactive = 0;

    public function label(): string
    {
        return match($this) {
            self::active => 'Активный',
            self::inactive => 'Неактивный',
        };
    }

    public function slug(): string
    {
        return match($this) {
            self::active => 'active',
            self::inactive => 'inactive',
        };
    }
}
