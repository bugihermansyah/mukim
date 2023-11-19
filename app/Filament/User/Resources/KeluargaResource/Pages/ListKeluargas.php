<?php

namespace App\Filament\User\Resources\KeluargaResource\Pages;

use App\Filament\User\Resources\KeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeluargas extends ListRecords
{
    protected static string $resource = KeluargaResource::class;

    public function getHeading(): string
    {
        return __('Anggota Keluarga');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
