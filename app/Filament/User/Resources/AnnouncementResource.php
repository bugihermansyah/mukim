<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Pengumuman';
    
    protected static ?string $pluralModelLabel = 'Pengumuman';

    protected static ?string $tenantOwnershipRelationshipName = 'buildings';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('')
                            // ->width(1024)
                            // ->height(300)
                            ->extraImgAttributes([
                                'margin-left' => 'auto',
                                'margin-right' => 'auto'
                            ]),
                            // ->columnSpan('full'),
                        TextEntry::make('user.name')
                            ->label('Penulis'),
                        TextEntry::make('title')
                            ->label('Judul')
                            ->html(),
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->html(),
                    ])
                    ->columns(1),
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
                TextColumn::make('user.name')
                    ->label('Penulis'),
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
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
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
            'view' => Pages\ViewAnnouncement::route('{record}'),
        ];
    }
}
