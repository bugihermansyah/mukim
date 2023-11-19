<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum VehicleType: string implements HasLabel
{
    case Mobil = 'mobil';
    case Motor = 'motor';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}