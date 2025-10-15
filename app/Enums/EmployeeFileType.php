<?php

namespace App\Enums;

enum EmployeeFileType: string
{
    case PASSPORT = 'passport';
    case MEDICAL_BOOK = 'medical_book';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::PASSPORT => 'Паспорт',
            self::MEDICAL_BOOK => 'Медицинская книжка',
            self::OTHER => 'Другие',
        };
    }
}
