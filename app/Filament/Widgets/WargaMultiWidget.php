<?php

namespace App\Filament\Widgets;

use Kenepa\MultiWidget\MultiWidget;

class WargaMultiWidget extends MultiWidget
{
    // protected static string $view = 'filament.widgets.warga-multi-widget';
    public array $widgets = [
        KelompokUsiaChart::class,
        KelompokAgamaChart::class,
    ];

    public function shouldPersistMultiWidgetTabsInSession(): bool
    {
        return true;
    }
}
