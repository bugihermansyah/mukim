<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use App\Filament\User\Resources\AnnouncementResource as UserAnnouncementResource;
use App\Filament\User\Resources\AnnouncementResource\Pages\EditAnnouncement;
use App\Models\Announcement;
use App\Models\Building;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $notice = $this->record;
        // $tenant = Filament::getTenant();

        $users = User::join('wargas', 'users.warga_id', '=', 'wargas.id')
        ->when($notice->is_gender !== null, function ($query) use ($notice) {
            return $query->whereIn('wargas.gender', $notice->is_gender);
        })
        ->when($notice->is_religion !== null, function ($query) use ($notice) {
            return $query->whereIn('wargas.religion', $notice->is_religion);
        })
        ->select('users.id','users.building_id')
        ->get();

        // insert tabel pivot
        foreach ($users as $user){
            $user->announcements()->attach($notice->id, ['building_id' => $user->building_id]);
        }

        foreach ($users as $user){
            Notification::make()
                ->title('Pengumuman')
                ->icon('heroicon-o-information-circle')
                ->iconColor('info')
                ->body("{$notice->title}")
                ->actions([
                    Action::make('Lihat')
                        ->button()
                        ->markAsRead()
                        ->url(Announcement::getUrl($notice, $user->building_id))
                ])
                ->sendToDatabase($user);
        }
    }
}
