<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EconomicStatus: string implements HasLabel
{
    case Keluarga_ekonomi_kurang_mampu = 'kurang_mampu';
    case Keluarga_ekonomi_menengah = 'menengah';
    case Keluarga_ekonomi_mampu = 'mampu';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', ' ')->title()->__toString();
    }
}