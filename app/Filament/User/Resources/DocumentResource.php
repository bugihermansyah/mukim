<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\DocumentResource\Pages;
use App\Filament\User\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Surat';
    
    protected static ?string $pluralModelLabel = 'Surat';

    protected static ?string $tenantOwnershipRelationshipName = 'buildings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->native(false)
                    ->displayFormat('d M Y')
                    ->default(Carbon::now())
                    ->required(),
                Select::make('warga_id')
                    ->label('Nama Warga')
                    ->relationship(name: 'warga', titleAttribute: 'full_name')
                    ->required(),
                TextInput::make('type')
                    ->label('Jenis Surat')
                    ->required(),
                TextInput::make('notes')
                    ->label('Keterangan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('warga.full_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Jenis Surat')
                    ->searchable(),
                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->searchable(),
                IconColumn::make('rt_status')
                    ->label('RT')
                    ->icon(fn (string $state): string => match ($state) {
                        'diproses' => 'heroicon-o-clock',
                        'disetujui' => 'heroicon-o-check-circle',
                        'ditolak' => 'heroicon-o-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'diproses' => 'info',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('rw_status')
                    ->label('RW')
                    ->icon(fn (string $state): string => match ($state) {
                        'diproses' => 'heroicon-o-clock',
                        'disetujui' => 'heroicon-o-check-circle',
                        'ditolak' => 'heroicon-o-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'diproses' => 'info',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('status')
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
                //
            ])
            ->actions([
                Action::make('pdf') 
                    ->label('Unduh')
                    ->visible(fn (Document $record) => $record->rt_status == 'disetujui' && $record->rw_status == 'disetujui')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Document $record) => route('pdf', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }    
}
