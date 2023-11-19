<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum GenderType: string implements HasLabel
{
    case Laki_laki = 'laki-laki';
    case Perempuan = 'perempuan';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', '-')->title()->__toString();
    }
}