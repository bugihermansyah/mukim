<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\EconomicStatus;
use App\Enums\HouseStatus;
use App\Enums\HunianStatus;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Model;
 
class EditBuildingProfile extends EditTenantProfile
{
    protected static ?string $recordTitleAttribute = 'slug';
    
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function getLabel(): string
    {
        return 'Informasi Rumah';
    }
    
    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
                ->schema([
                    TextInput::make('owner')
                        ->label('Pemilik')
                        ->required(),
                    Select::make('is_used')
                        ->label('Penggunaan rumah')
                        ->options(HunianStatus::class)
                        ->required(),
                    TextInput::make('rate')
                        ->label('Iuran IPL')
                        ->prefix('Rp')
                        ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 0)
                        ->required(),
                    Select::make('is_house')
                        ->label('Status Hunian')
                        ->options(HouseStatus::class)
                        ->required(),
                    Select::make('is_economic')
                        ->label('Status ekonomi keluarga')
                        ->options(EconomicStatus::class)
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make()
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('name')
                                            ->label('Nama'),
                                        TextEntry::make('period')
                                            ->label('Periode'),
                                    ]),
                                    Group::make([
                                        TextEntry::make('price')
                                            ->label('Harga'),
                                        TextEntry::make('penerima')
                                            ->label('asd')
                                    ]),
                                ]),
                    ])->from('lg'),
                ]),
            ]);
    }
    

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Data berhasil disimpan');
    }
}