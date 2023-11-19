<?php

namespace App\Filament\Resources\HomeUseResource\Pages;

use App\Filament\Resources\HomeUseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeUse extends EditRecord
{
    protected static string $resource = HomeUseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
