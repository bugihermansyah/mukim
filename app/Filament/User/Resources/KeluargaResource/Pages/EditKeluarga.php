<?php

namespace App\Filament\User\Resources\KeluargaResource\Pages;

use App\Filament\User\Resources\KeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeluarga extends EditRecord
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
