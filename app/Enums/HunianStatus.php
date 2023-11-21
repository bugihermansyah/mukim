<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HunianStatus: string implements HasLabel
{
    case Pribadi_Keluarga = 'pribadi';
    case Kontrakan_Sewa = 'kontrakan';
    case Panti = 'panti';
    case Kost = 'kost';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', ' / ')->title()->__toString();
    }
}