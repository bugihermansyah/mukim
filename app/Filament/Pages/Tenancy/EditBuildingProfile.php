<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Model;
 
class EditBuildingProfile extends EditTenantProfile
{
    protected static ?string $recordTitleAttribute = 'slug';

    public static function getLabel(): string
    {
        return 'Edit Rumah';
    }
    
    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
                ->schema([
                    TextInput::make('owner')
                        ->label('Nama Pemilik')
                        ->required(),
                    TextInput::make('phone')
                        ->label('Telepon'),
                    Select::make('is_house')
                        ->label('Status Rumah')
                        ->options([
                            '1' => 'satu',
                        ])
                        ->required(),
                    Select::make('is_used')
                        ->label('Fungsi Rumah')
                        ->options([
                            '1' => 'satu',
                        ])
                        ->required(),
                    Select::make('is_economic')
                        ->label('Status Ekonomi')
                        ->options([
                            '1' => 'satu',
                        ])
                        ->required(),
                    TextInput::make('rate')
                        ->label('Iuran Bulanan')
                        ->prefix('Rp')
                        ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 0)
                        ->required(),       
                ])
                ->columns(2)
        ]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Data berhasil disimpan');
    }
}