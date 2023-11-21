<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HouseStatus: string implements HasLabel
{
    case Tempat_Tinggal = 'tempat_tinggal';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', ' ')->title()->__toString();
    }
}