<?php

namespace App\Filament\Resources\HomeUseResource\Pages;

use App\Filament\Resources\HomeUseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeUses extends ListRecords
{
    protected static string $resource = HomeUseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
