<?php

namespace App\Enums;

enum EmployeeFileType: string
{
    case PASSPORT = 'passport';
    case INN = 'inn';
    case SNILS = 'snils';
    case MEDICAL_BOOK = 'medical_book';
}
