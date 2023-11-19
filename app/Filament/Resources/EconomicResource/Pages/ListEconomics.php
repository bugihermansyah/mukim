<?php

namespace App\Filament\Resources\EconomicResource\Pages;

use App\Filament\Resources\EconomicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEconomics extends ListRecords
{
    protected static string $resource = EconomicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
