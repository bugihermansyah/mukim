<?php

namespace App\Filament\User\Resources;

use App\Enums\MonthList;
use App\Filament\User\Resources\OrderResource\Pages;
use App\Filament\User\Resources\OrderResource\RelationManagers;
use App\Models\Building;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Vehicle;
use Filament\Forms;
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
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Get;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Grouping\Group;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationLabel = 'Iuran';
    
    protected static ?string $pluralModelLabel = 'Iuran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Hidden::make('building_id')
                        ->default(Filament::getTenant()->id),
                    Select::make('product_id')
                        ->label('Produk')
                        ->options(fn (): array => 
                            Product::all()
                                ->mapWithKeys(fn ($product) => 
                                    [$product->id => $product->name . ' ' . $product->period]
                                )
                                ->toArray()
                        )
                        ->searchable()
                        ->required(),
                    TextInput::make('notes')
                        ->label('Keterangan')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->columns(2),
                Section::make([
                    Repeater::make('orderitems')
                        ->label('Item')
                        ->relationship()
                        // ->headers(['Item', 'Harga'])
                        ->schema([
                            Select::make('period')
                                ->label('Item')
                                ->options(MonthList::class)
                                ->disableOptionWhen(function ($value , $state, Get $get){
                                    return collect($get('../*.period'))
                                        ->reject(fn($id) => $id == $state)
                                        ->filter()
                                        ->contains($value);
                                })
                                ->searchable()
                                ->required(),
                            TextInput::make('rate')
                                ->label('Harga')
                                ->prefix('Rp')
                                ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 0)
                                ->default(Filament::getTenant()->rate)
                                ->required(),
                        ]) 
                        ->orderColumn('sort')     
                        ->reorderableWithButtons()
                        ->reorderableWithDragAndDrop(false)                  
                        ->addActionLabel('Tambah item')
                        ->columns(2)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice')
                    ->label('No. Inv')
                    ->sortable(),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->sortable(),
                TextColumn::make('product.period')
                    ->label('Period')
                    ->sortable(),
                TextColumn::make('orderitems_count')
                    ->label('Item')
                    ->counts('orderitems')
                    ->sortable(),
                TextColumn::make('orderitems_sum_rate')
                    ->label('Total')
                    ->sum('orderitems','rate')
                    ->currency('IDR')
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('Keterangan'),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
