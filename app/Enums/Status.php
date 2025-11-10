<?php

namespace App\Enums;

enum Status : int
{
    case draft = 0;
    case published = 1;

    public function label(): string
    {
        return match ($this) {
            self::draft => 'Черновик',
            self::published => 'Опубликован',
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::draft => 'draft',
            self::published => 'published',

        };
    }
}
