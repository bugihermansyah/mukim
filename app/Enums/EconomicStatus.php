<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EconomicStatus: string implements HasLabel
{
    case Ekonomi_kurang_mampu = 'kurang mampu';
    case Ekonomi_menengah = 'menengah';
    case Ekonomi_mampu = 'mampu';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', '-')->title()->__toString();
    }
}