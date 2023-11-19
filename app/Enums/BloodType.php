<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BloodType: string implements HasLabel
{
    case A = 'A';
    case B = 'B';
    case AB = 'AB';
    case O = 'O';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}