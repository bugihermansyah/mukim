<?php

namespace App\Filament\Resources;

use App\Enums\GenderType;
use App\Enums\ReligionList;
use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Pengumuman';
    
    protected static ?string $pluralModelLabel = 'Pengumuman';
    
    protected static ?string $navigationGroup = 'Manajemen Warga';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Fieldset::make('Foto')
                            ->schema([
                                FileUpload::make('photo')
                                    ->label(''),
                            ])
                            ->columns('full'),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('announcement_type')
                            ->label('Jenis Pengumuman'),
                        TextInput::make('title')
                            ->label('Judul'),
                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                        Fieldset::make('Spesifikasi penerima')
                            ->schema([
                                Select::make('is_gender')
                                    ->label('Jenis Kelamin')
                                    ->multiple()
                                    ->options(GenderType::class)
                                    ->default(['laki-laki','perempuan'])
                                    ->required(),
                                Select::make('is_religion')
                                    ->label('Agama')
                                    ->multiple()
                                    ->options(ReligionList::class)
                                    ->default(['islam','kristen','katolik','hindu','budha','konghuchu','kepercayaan'])
                                    ->required(),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Thumbnail'),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                 
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                 
                        return $state;
                    })
                    ->limit(35),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->html()
                    ->wrap()
                    ->limit(70),
                TextColumn::make('is_gender')
                    ->label('Gender')
                    ->badge(),
                TextColumn::make('is_religion')
                    ->label('Agama')
                    ->badge(),
                TextColumn::make('user.name')
                    ->label('Dibuat'),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
