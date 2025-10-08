<?php

namespace App\Enums;

enum EmployeeFileType: string
{
    case PASSPORT = 'passport';
    case INN = 'inn';
    case SNILS = 'snils';
    case MEDICAL_BOOK = 'medical_book';

    public function label(): string
    {
        return match ($this) {
            self::PASSPORT => 'Паспорт',
            self::INN => 'ИНН',
            self::SNILS => 'СНИЛС',
            self::MEDICAL_BOOK => 'Медицинская книжка',
        };
    }
}
