<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EconomicStatus: string implements HasLabel
{
    case KurangMampu = 'kurang_mampu';
    case Menengah = 'menengah';
    case Mampu = 'mampu';

    public function getLabel(): string
    {
        return match ($this) {
            self::KurangMampu => 'Keluarga Ekonomi Kurang Mampu',
            self::Menengah => 'Keluarga Ekonomi Menengah',
            self::Mampu => 'Keluarga Ekonomi Mampu',
        };
    }
}