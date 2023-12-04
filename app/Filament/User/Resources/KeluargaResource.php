<?php

namespace App\Filament\User\Resources;

use App\Enums\BloodType;
use App\Enums\FamilyStatus;
use App\Enums\GenderType;
use App\Enums\ReligionList;
use App\Filament\User\Resources\KeluargaResource\Pages;
use App\Filament\User\Resources\KeluargaResource\RelationManagers;
use App\Models\Building;
use App\Models\Education;
use App\Models\Employment;
use App\Models\Rtrw;
use App\Models\User;
use App\Models\Warga;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
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

    protected static ?string $recordTitleAttribute = 'full_name';

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
                                TextInput::make('nik')
                                    ->label('NIK')
                                    ->placeholder('Nomor Induk Kependudukan')
                                    ->numeric()
                                    ->length(16),
                                TextInput::make('full_name')
                                    ->label('Nama lengkap')
                                    ->placeholder('Nama lengkap sesuai KTP')
                                    ->required(),
                                TextInput::make('birthplace')
                                    ->label('Tempat lahir')
                                    ->placeholder('Nama daerah tempat lahir')
                                    ->required(),
                                DatePicker::make('dob')
                                    ->label('Tanggal lahir')
                                    ->required(),
                                Select::make('religion')
                                    ->label('Agama')
                                    ->options(ReligionList::class)
                                    ->searchable()
                                    ->required(),
                                Select::make('employment_id')
                                    ->label('Pekerjaan')
                                    ->options(Employment::query()->pluck('name','id'))
                                    ->searchable()
                                    ->required(),
                                Radio::make('gender')
                                    ->label('Jenis kelamin')
                                    ->options(GenderType::class)
                                    ->required(),
                                Radio::make('citizen')
                                    ->label('Kewarganegaraan')
                                    ->options([
                                        'WNI' => 'WNI',
                                        'WNA' => 'WNA'
                                    ])
                                    ->default('WNI')
                                    ->descriptions([
                                        'WNI' => 'Warga Negara Indonesia',
                                        'WNA' => 'Warga Negara Asing'
                                    ])
                                    ->required(),
                            ])
                            ->columns(2),
                        Section::make()
                            ->schema([
                                Textarea::make('address')
                                    ->label('Alamat')
                                    ->columnSpan('full'),

                                TextInput::make('rtrw')
                                    ->label('RT/RW'),

                                TextInput::make('village')
                                    ->label('Kel/Desa'),

                                TextInput::make('subdistrict')
                                    ->label('Kecamatan'),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Foto')
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Foto')
                            ])
                            ->collapsed(),

                        Section::make()
                            ->schema([
                                TextInput::make('handphone')
                                    ->label('Handphone')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                                TextInput::make('telephone')
                                    ->label('Telephone')
                                    ->placeholder('Telephone rumah')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                            ]),

                        Section::make()
                            ->schema([
                                Select::make('relationship_family')
                                    ->label('Hubungan keluarga')
                                    ->options(FamilyStatus::class)
                                    ->searchable()
                                    ->required(),
                                Select::make('blood_type')
                                    ->label('Gol. Darah')
                                    ->options(BloodType::class)
                                    ->searchable(),
                                Select::make('education_id')
                                    ->label('Pendidikan')
                                    ->options(Education::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
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
                TextColumn::make('rtrw.name')
                    ->label('RT/RW')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('building.slug')
                    ->label('Rumah')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('birthplace')
                    ->label('Tempat Lahir')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->label('Jenis kelamin')                    
                    ->formatStateUsing(fn (string $state): string => ucwords(__("{$state}")))
                    ->searchable(),
                TextColumn::make('blood_type')
                    ->label('Gol. Darah')
                    ->searchable(),
                TextColumn::make('employment.name')
                    ->label('Pekerjaan')
                    ->searchable(),
                TextColumn::make('education.name')
                    ->label('Pendidikan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('handphone')
                    ->label('Handphone')
                    ->searchable(),
                TextColumn::make('telephone')
                    ->label('Telephone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('citizen')
                    ->label('Kewarganegaraan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
