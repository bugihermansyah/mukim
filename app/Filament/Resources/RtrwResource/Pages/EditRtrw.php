<?php

namespace App\Filament\Resources\RtrwResource\Pages;

use App\Filament\Resources\RtrwResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRtrw extends EditRecord
{
    protected static string $resource = RtrwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
