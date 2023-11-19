<?php

namespace App\Filament\Resources\EconomicResource\Pages;

use App\Filament\Resources\EconomicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEconomic extends EditRecord
{
    protected static string $resource = EconomicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
