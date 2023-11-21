<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HunianStatus: string implements HasLabel
{
    case Tempat_Tinggal = 'tempat_tinggal';

    public function getLabel(): string
    {
        return match ($this) {
            self::Tempat_Tinggal => 'Tempat Tinggal',
        };
    }

}