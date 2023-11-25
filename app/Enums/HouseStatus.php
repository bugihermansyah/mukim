<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HouseStatus: string implements HasLabel
{
    case Pribadi = 'pribadi';
    case Sewa = 'kontrakan';
    case Panti = 'panti';
    case Kost = 'kost';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pribadi => 'Pribadi / Keluarga',
            self::Sewa => 'Kontrakan / Sewa',
            self::Panti => 'Rumah Panti',
            self::Kost => 'Rumah Kost',
        };
    }
}