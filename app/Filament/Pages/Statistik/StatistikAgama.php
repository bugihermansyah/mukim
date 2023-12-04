<?php

namespace App\Filament\Pages\Statistik;

use App\Filament\Widgets\WargaReligionChart;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class StatistikAgama extends Page
{
    use HasPageSidebar;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.statistik-agama';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string | Htmlable
    {
        return __('');
    }

    public static function sidebar(): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle('Informasi Statistik')
            ->setDescription('Menampilkan informasi data berupa diagram')
            ->setNavigationItems([
                PageNavigationItem::make('Rumah')
                    ->icon('heroicon-o-home-modern')
                    ->url(StatistikAgama::getUrl())
                    ->visible(true),
                PageNavigationItem::make('Agama')
                    ->icon('heroicon-o-heart')
                    ->url(StatistikAgama::getUrl())
                    ->visible(true),
                PageNavigationItem::make('Kelompok Usia')
                    ->icon('heroicon-o-identification')
                    ->url(StatistikKelompokUsia::getUrl())
                    ->visible(true),
                PageNavigationItem::make('Pendidikan')
                    ->icon('heroicon-o-academic-cap')
                    ->url(StatistikEducation::getUrl())
                    ->visible(true),
                PageNavigationItem::make('Gol. Darah')
                    ->icon('heroicon-o-beaker')
                    ->url(StatistikBloodType::getUrl())
                    ->visible(true),
        ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WargaReligionChart::class
        ];
    }
}
