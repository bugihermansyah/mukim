<?php

namespace App\Filament\User\Resources\KeluargaResource\Pages;

use App\Filament\Resources\WargaResource;
use App\Filament\User\Resources\KeluargaResource;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Request;

class CreateKeluarga extends CreateRecord
{
    protected static string $resource = KeluargaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $building = Filament::getTenant();
        $data['rtrw_id'] = $building->rtrw_id;
        $data['building_id'] = $building->id;

        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $warga = $this->record;
        $tenant = Filament::getTenant();
        $toAdmin = User::role(['pengurus','super_admin','bendahara'])->get();
        $toPerdes = User::whereHas('rtrws', function ($query) use ($warga){
                        $query->where('id', $warga->rtrw_id);
                    })->role(['ketua_rt'])->get();

            // Notification::make()
            //     ->title('Anggota keluarga')
            //     ->icon('heroicon-o-document')
            //     ->body("Warga <b>{$tenant->block}/{$tenant->number}</b> menambahkan anggota keluarga")
            //     ->actions([
            //         Action::make('Lihat')
            //             ->button()
            //             ->markAsRead()
            //             ->url(WargaResource::getUrl('edit',['record' => $warga], panel: 'admin')),
            //     ])
            //     ->sendToDatabase($toAdmin);

            Notification::make()
                ->title('Anggota keluarga')
                ->icon('heroicon-o-document')
                ->body("Warga <b>{$tenant->block}/{$tenant->number}</b> menambahkan anggota keluarga")
                ->actions([
                    Action::make('Lihat')
                        ->button()
                        ->markAsRead()
                        // ->url(WargaResource::getUrl('view',['record' => $warga], panel: 'admin')),
                        ->url(route('filament.admin.resources.wargas.view', ['record' => $warga])),
                ])
                ->sendToDatabase($toPerdes);
    }
}