<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum VehicleColor: string implements HasLabel
{
    case Hitam = 'hitam';
    case Putih = 'putih';
    case Silver = 'silver';
    case Abu_abu = 'abu-abu';
    case Merah = 'merah';
    case Biru = 'biru';
    case Kuning = 'kuning';
    case lainnya = 'lainnya';

    public function getLabel(): ?string
    {
        return str($this->name)->replace('_', '-')->title()->__toString();
    }
}