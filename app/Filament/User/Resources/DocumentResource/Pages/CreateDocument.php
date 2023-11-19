<?php

namespace App\Filament\User\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource AS DocumentResourceAdmin;
use App\Filament\User\Resources\DocumentResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['url'] = rand(1000000, 9999999);
        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $recipient = User::role(['super_admin','pengurus','ketua_rt','ketua_rw'])->get();
        $tenant = Filament::getTenant();
        $document = $this->record;

        Notification::make()
            ->title('Permintaan surat baru')
            ->icon('heroicon-o-document')
            ->body("Warga <b>{$tenant->block}/{$tenant->number}</b> membuat surat keterangan")
            ->actions([
                Action::make('Lihat')
                    ->button()
                    ->markAsRead()
                    ->url(DocumentResourceAdmin::getUrl('edit',['record' => $document], panel: 'admin')),
            ])
            ->sendToDatabase($recipient);
    }
}
