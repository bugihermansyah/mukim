<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FamilyStatus: string implements HasLabel
{
    case Kepala_Keluarga = 'kepala_keluarga';
    case Istri = 'istri';
    case Anak = 'anak';
    case Lainnya = 'lainnya';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', ' ')->title()->__toString();
    }
}