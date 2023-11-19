<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel, HasColor
{
    case Dibuat = 'dibuat';
    case Dikonfirmasi = 'dikonfirmasi';
    case Dibatalkan = 'dibatalkan';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Dibuat => 'warning',
            self::Dikonfirmasi => 'success',
            self::Dibatalkan => 'danger',
        };
    }
}
