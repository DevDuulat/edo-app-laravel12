<?php

namespace App;

enum Status: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Черновик',
            self::PUBLISHED => 'Опубликован',
            self::ARCHIVED => 'Архивирован',
        };
    }
}
