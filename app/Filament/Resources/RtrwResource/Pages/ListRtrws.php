<?php

namespace App\Filament\Resources\RtrwResource\Pages;

use App\Filament\Resources\RtrwResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRtrws extends ListRecords
{
    protected static string $resource = RtrwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
