<?php

namespace App\Filament\User\Resources\AnnouncementResource\Pages;

use App\Filament\User\Resources\AnnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewAnnouncement extends ViewRecord
{
    protected static string $resource = AnnouncementResource::class;

    public function getTitle(): string | Htmlable
    {
        // if (filled(static::$title)) {
        //     return static::$title;
        // }

        return __('filament-panels::resources/pages/view-record.title', [
            'label' => '',
        ]);
    }
}
