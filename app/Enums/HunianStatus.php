<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HunianStatus: string implements HasLabel
{
    case TempatTinggal = 'tempat tinggal';
    case Kantor = 'kantor';
    case Gudang = 'gudang';

    public function getLabel(): string
    {
        return match ($this) {
            self::TempatTinggal => 'Tempat Tinggal',
            self::Kantor => 'Kantor',
            self::Gudang => 'Gudang',
        };
    }

}