<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MonthList: string implements HasLabel
{
    case Januari = 'januari';
    case Februari = 'februari';
    case Maret = 'maret';
    case April = 'april';
    case Mei = 'mei';
    case Juni = 'juni';
    case Juli = 'juli';
    case Agustus = 'agustus';
    case September = 'september';
    case Oktober = 'oktober';
    case November = 'november';
    case Desember = 'desember';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}