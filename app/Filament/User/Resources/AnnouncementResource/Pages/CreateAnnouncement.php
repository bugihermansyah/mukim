<?php

namespace App\Filament\User\Resources\AnnouncementResource\Pages;

use App\Filament\User\Resources\AnnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;
}
