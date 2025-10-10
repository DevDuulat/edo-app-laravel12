<?php

namespace App\Enums;

enum DocumentType: int
{
    case incoming = 0;
    case outgoing = 1;
    case internal = 2;

    public function label(): string
    {
        return match ($this) {
            self::incoming => 'Входящий документ',
            self::outgoing => 'Исходящий документ',
            self::internal => 'Внутренний документ',
        };
    }
    public function slug(): string
    {
        return match($this) {
            self::incoming => 'incoming',
            self::outgoing => 'outgoing',
            self::internal => 'internal',
        };
    }
}



