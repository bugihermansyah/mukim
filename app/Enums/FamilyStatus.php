<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FamilyStatus: string implements HasLabel
{
    case KepalaKeluarga = 'kepala keluarga';
    case Istri = 'istri';
    case Anak = 'anak';
    case OrangTua = 'orang tua';
    case ART = 'art';
    case Supir = 'supir';

    public function getLabel(): string
    {
        return match ($this) {
            self::KepalaKeluarga => 'Kepala Keluarga',
            self::Istri => 'Istri',
            self::Anak => 'Anak',
            self::OrangTua => 'Orang Tua',
            self::ART => 'ART',
            self::Supir => 'Supir',
        };
    }
}