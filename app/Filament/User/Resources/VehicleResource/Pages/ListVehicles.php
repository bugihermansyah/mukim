<?php

namespace App\Filament\User\Resources\VehicleResource\Pages;

use App\Filament\User\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    public function getHeading(): string
    {
        return __('Kendaraan');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
