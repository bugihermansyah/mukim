<?php

namespace App\Filament\Pages\Statistik;

use App\Filament\Widgets\WargaMultiWidget;
use Filament\Pages\Page;

class StatistikWarga extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.statistik.statistik-warga';

    protected function getHeaderWidgets(): array
    {
        return [
            WargaMultiWidget::class
        ];
    }
}
