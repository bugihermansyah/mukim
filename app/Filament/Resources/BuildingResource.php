<?php

namespace App\Filament\Resources;

use App\Enums\EconomicStatus;
use App\Enums\HouseStatus;
use App\Enums\HunianStatus;
use App\Filament\Resources\BuildingResource\Pages;
use App\Filament\Resources\BuildingResource\RelationManagers;
use App\Models\Building;
use App\Models\Rtrw;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BuildingResource extends Resource
{
    protected static ?string $model = Building::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    
    protected static ?string $navigationLabel = 'Rumah';

    protected static ?string $pluralModelLabel = 'Rumah';
    
    protected static ?string $modelLabel = 'Rumah';
    
    protected static ?string $navigationGroup = 'Manajemen Warga';
    
    protected static ?string $recordTitleAttribute = 'slug';
    
    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('rtrw_id')
                            ->label('RT/RW')
                            ->relationship(name: 'rtrw', titleAttribute: 'name')
                            ->required(),
                        TextInput::make('block')
                            ->label('Blok')
                            ->live()
                            ->extraInputAttributes(['oninput' => 'this.value = this.value.toUpperCase()'])
                            // ->formatStateUsing(fn ($state) => strtoupper($state))
                            // ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                            ->afterStateUpdated(fn ($get, $set) => $set('slug', $get('block') . '/' . $get('number')))
                            ->required(),
                        TextInput::make('number')
                            ->label('Nomor')
                            ->live()
                            ->extraInputAttributes(['oninput' => 'this.value = this.value.toUpperCase()'])
                            // ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                            ->afterStateUpdated(fn ($get, $set) => $set('slug', $get('block') . '/' . $get('number')))
                            ->required(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->hidden()
                            // ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                            // ->disabled()
                            ->unique(ignoreRecord: true, column: 'slug')
                            ->required(),
                    ])
                    ->columns(3),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rtrw.name')
                    ->label('RT/RW')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('block')
                    ->label('Blok')
                    ->searchable(),
                TextColumn::make('number')
                    ->label('Nomor')
                    ->searchable(),
                TextColumn::make('owner')
                    ->label('Pemilik')
                    ->searchable(),
                TextColumn::make('is_used')
                    ->label('Status Penggunaan')
                    ->searchable(),
                TextColumn::make('is_house')
                    ->label('Status Hunian')
                    ->searchable(),
                TextColumn::make('is_economic')
                    ->label('Status ekonomi keluarga')
                    ->searchable(),
                TextColumn::make('rate')
                    ->label('Iuran IPL')
                    ->currency('IDR')
                    ->sortable(),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            'index' => Pages\ListBuildings::route('/'),
            'create' => Pages\CreateBuilding::route('/create'),
            'edit' => Pages\EditBuilding::route('/{record}/edit'),
        ];
    }
}
