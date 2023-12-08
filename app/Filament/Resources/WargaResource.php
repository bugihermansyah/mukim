<?php

namespace App\Filament\Resources;

use App\Enums\BloodType;
use App\Enums\FamilyStatus;
use App\Enums\GenderType;
use App\Enums\ReligionList;
use App\Event\CreateUserEvent;
use App\Filament\Resources\WargaResource\Pages;
use App\Models\Building;
use App\Models\Education;
use App\Models\Employment;
use App\Models\Rtrw;
use App\Models\User;
use App\Models\Warga;
use Filament\Infolists\Infolist;
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
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group as InfoListGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WargaResource extends Resource
{
    protected static ?string $model = Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Warga';

    protected static ?string $pluralModelLabel = 'Warga';
    
    protected static ?string $navigationGroup = 'Manajemen Warga';

    protected static ?string $recordTitleAttribute = 'full_name';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('rtrw_id')
                                    ->label('RT/RW')
                                    ->options(Rtrw::query()->pluck('name','id'))
                                    ->searchable()
                                    ->required()
                                    ->live(),
                                Select::make('building_id')
                                    ->label('Rumah')
                                    ->options(fn (Get $get): array => Building::query()
                                        ->where('rtrw_id', $get('rtrw_id'))
                                        ->get()
                                        ->mapWithKeys(fn ($customer) => 
                                            [$customer->id => $customer->block . '/' . $customer->number]
                                        )
                                        ->toArray()
                                    )
                                    ->searchable()
                                    ->required(),
                            ])
                            ->columns(2),
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
                TextColumn::make('rtrw_id')
                    ->label('RT/RW')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('building_id')
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
                // \EightyNine\Approvals\Tables\Actions\ApprovalActions::make(
                //         Tables\Actions\Action::make("Done")
                // ),
                Tables\Actions\Action::make('create_user')
                    ->label('Buat Akun')
                    ->icon('heroicon-m-user-plus')
                    ->color('info')
                    ->visible(function (Warga $record) {
                        return !User::where('warga_id', $record->id)->exists();
                    })
                    ->requiresConfirmation()
                    ->action(function (Warga $record) {
                        event(new CreateUserEvent($record));
                        Notification::make()
                            ->title('Berhasil Buat Akun')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make(),
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
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoListSection::make()
                    ->schema([
                        Split::make([
                            Grid::make(3)
                            ->schema([
                                ImageEntry::make('photo')
                                    ->defaultImageUrl(url('storage/default-photo-profile.jpg'))
                                    ->hiddenLabel()
                                    ->grow(false),
                                InfoListGroup::make([
                                    TextEntry::make('rtrw.name')
                                        ->label('RT/RW')
                                        ->weight(FontWeight::Bold),
                                    TextEntry::make('building.slug')
                                        ->label('Blok Rumah')
                                        ->weight(FontWeight::Bold),
                                ])->columns(2),
                            ])
                        ])->from('lg'),
                    ]),
                InfoListSection::make('Data Diri')
                    ->description('Informasi data diri')
                    ->aside()
                    ->schema([
                        InfoListGroup::make([
                            TextEntry::make('full_name')
                                ->label('Nama Lengkap')
                                ->placeholder('-'),
                            TextEntry::make('nik')
                                ->label('NIK')
                                ->placeholder('-'),
                        ])->columns(3),
                        
                        InfoListGroup::make([
                            TextEntry::make('gender')
                                ->label('Jenis Kelamin')
                                ->placeholder('-'),
                            TextEntry::make('birthplace')
                                ->label('Tempat lahir')
                                ->placeholder('-'),
                            TextEntry::make('dob')
                                ->label('Tanggal lahir')
                                ->date('d F Y')
                                ->placeholder('-'),
                            TextEntry::make('religion')
                                ->label('Agama')
                                ->formatStateUsing(fn (string $state): string => ucwords(__("{$state}")))
                                ->placeholder('-'),
                            TextEntry::make('blood_type')
                                ->label('Gol. Darah')
                                ->placeholder('-'),
                            TextEntry::make('employment.name')
                                ->label('Pekerjaan')
                                ->placeholder('-'),
                            TextEntry::make('education.name')
                                ->label('Gol. Darah')
                                ->placeholder('-'),
                            TextEntry::make('relationship_family')
                                ->label('Status Keluarga')
                                ->placeholder('-'),
                            TextEntry::make('handphone')
                                ->label('Handphone')
                                ->placeholder('-'),
                            TextEntry::make('telephone')
                                ->label('Telephone')
                                ->placeholder('-'),
                            TextEntry::make('citizen')
                                ->label('Kewarganegaraan')
                                ->formatStateUsing(fn (string $state): string => strtoupper(__("{$state}")))
                                ->placeholder('-'),
                        ])->columns(3)
                    ]),
                InfoListSection::make('Alamat')
                    ->description('Alamat lengkap berdasarkan Kartu Tanda Penduduk')
                    ->aside()
                    ->schema([
                        TextEntry::make('address')
                            ->label('Alamat')
                            ->placeholder('-'),
                        InfoListGroup::make([
                            TextEntry::make('rtrw')
                                ->label('RT/RW')
                                ->placeholder('-'),
                            TextEntry::make('village')
                                ->label('Desa/Kelurahan')
                                ->placeholder('-'),
                            TextEntry::make('subdistrict')
                                ->label('Kecamatan')
                                ->placeholder('-'),
                        ])->columns(3)
                    ]),
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
            'index' => Pages\ListWargas::route('/'),
            'create' => Pages\CreateWarga::route('/create'),
            'view' => Pages\ViewWarga::route('/{record}'),
            'edit' => Pages\EditWarga::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
