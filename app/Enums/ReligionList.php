<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReligionList: string implements HasLabel
{
    case Islam = 'islam';
    case Kristen = 'kristen';
    case Katolik = 'katolik';
    case Hindu = 'hindu';
    case Budha = 'budha';
    case Konghuchu = 'konghuchu';
    case Kepercayaan = 'kepercayaan';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}