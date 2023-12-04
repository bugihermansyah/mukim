<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ConfirmStatus: string implements HasLabel, HasColor
{
    case Baru = 'baru';
    case Terima = 'terima';
    case Tolak = 'tolak';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Baru => 'warning',
            self::Terima => 'success',
            self::Tolak => 'danger',
        };
    }
}