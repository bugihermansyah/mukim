<?php

namespace App\Filament\User\Resources\VehicleResource\Pages;

use App\Filament\User\Resources\VehicleResource;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateVehicle extends CreateRecord
{
    protected static string $resource = VehicleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $recipient = User::role('pengurus')->get();
        $tenant = Filament::getTenant();
        $vehicle = $this->record;

        Notification::make()
            ->title('Kendaraan baru')
            ->icon('heroicon-o-truck')
            ->body("Warga <b>{$tenant->block}/{$tenant->number}</b> menambahkan kendaraan baru")
            ->actions([
                Action::make('Lihat')
                    ->url(VehicleResource::getUrl('edit', ['record' => $vehicle])),
            ])
            ->sendToDatabase($recipient);
    }
}
