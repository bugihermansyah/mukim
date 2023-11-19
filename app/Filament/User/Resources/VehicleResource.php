<?php

namespace App\Filament\User\Resources;

use App\Enums\VehicleColor;
use App\Enums\VehicleType;
use App\Filament\User\Resources\VehicleResource\Pages;
use App\Filament\User\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Kendaraan';
    
    protected static ?string $pluralModelLabel = 'Keluarga';

    protected static ?string $tenantOwnershipRelationshipName = 'buildings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nopol')
                    ->label('No. Plat')
                    ->unique(Vehicle::class, 'nopol', ignoreRecord: true)
                    ->required(),
                Radio::make('type')
                    ->label('Kelas Kendaraan')
                    ->options(VehicleType::class)
                    ->default('mobil'),
                // Select::make('type')
                //     ->label('Kelas Kendaraan')
                //     ->options(VehicleType::class),
                TextInput::make('merk_type')
                    ->label('Merek - Tipe')
                    ->required(),
                Select::make('color')
                    ->label('Warna')
                    ->options(VehicleColor::class),
                Textarea::make('information')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nopol')
                    ->label('Plat Nomor')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Kendaraan')
                    ->formatStateUsing(fn (string $state): string => ucwords(__("{$state}")))
                    ->searchable(),
                TextColumn::make('merk_type')
                    ->label('Merek / Tipe')
                    ->searchable(),
                TextColumn::make('color')
                    ->label('Warna')
                    ->formatStateUsing(fn (string $state): string => ucwords(__("{$state}")))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('updateColor')
                    ->fillForm(fn (Vehicle $record): array => [
                        'color' => $record->color,
                    ])
                    ->form([
                        Select::make('color')
                        ->label('Warna')
                        ->options(VehicleColor::class),
                        ])
                    ->action(function (array $data, Vehicle $record): Model {
                        $record->update($data);
 
                        return $record;
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
