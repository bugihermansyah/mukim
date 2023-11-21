<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\KeluargaResource\Pages;
use App\Filament\User\Resources\KeluargaResource\RelationManagers;
use App\Models\Warga;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeluargaResource extends Resource
{
    protected static ?string $model = Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Keluarga';

    protected static ?string $pluralModelLabel = 'Keluarga';

    protected static ?string $slug = 'keluarga';

    protected static ?string $tenantOwnershipRelationshipName = 'building';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),

                                TextInput::make('slug')
                                    ->disabled(),
                            ])
                            ->columns(2),

                        Section::make('Images')
                            ->collapsible(),

                        Section::make('Pricing')
                            ->schema([
                                TextInput::make('price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),

                                TextInput::make('old_price')
                                    ->label('Compare at price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),

                                TextInput::make('cost')
                                    ->label('Cost per item')
                                    ->helperText('Customers won\'t see this price.')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                            ])
                            ->columns(2),
                        Section::make('Alamat')
                            ->schema([
                                Textarea::make('address')
                                    ->label('Alamat')
                                    ->columnSpan('full')
                                    ->required(),

                                TextInput::make('rtrw')
                                    ->label('RT/RW')
                                    ->required(),

                                TextInput::make('village')
                                    ->label('Kel/Desa')
                                    ->required(),

                                TextInput::make('security_stock')
                                    ->label('Kecamatan')
                                    ->required(),
                            ])
                            ->columns(3),

                        Section::make('Shipping')
                            ->schema([
                                TextInput::make('backorder')
                                    ->label('This product can be returned'),

                                TextInput::make('requires_shipping')
                                    ->label('This product will be shipped'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([

                                DatePicker::make('published_at')
                                    ->label('Availability')
                                    ->default(now())
                                    ->required(),
                            ]),

                        Section::make('Associations')
                            ->schema([
                                Select::make('shop_brand_id'),

                                Select::make('categories'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('dob')
                    ->label('Tanggal lahir')
                    ->date('d M Y')
                    ->searchable(),
                TextColumn::make('relationship_family')
                    ->label('Hubungan keluarga')
                    ->formatStateUsing(fn (string $state): string => ucwords(__("{$state}")))
                    ->searchable(),
                TextColumn::make('religion')
                    ->label('Agama')
                    ->formatStateUsing(fn (string $state): string => ucwords(__("{$state}")))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListKeluargas::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }
}
