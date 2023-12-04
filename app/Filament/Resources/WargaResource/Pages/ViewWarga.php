<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\ViewRecord;

class ViewWarga extends ViewRecord
{

    protected static string $resource = WargaResource::class;

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\Action::make('Aprove')
    //             ->action(function (Warga $record) { 
    //                 $record->status = 1;
    //                 $record->save();
    //             })
    //             ->visible(function (Warga $record){
    //                 return $record->status == 0;
    //             })
    //             ->requiresConfirmation(),
    //         Actions\Action::make('Terima')
    //             ->action(function (Warga $record) {
    //                 $record->status = ConfirmStatus::Terima;
    //                 $record->save();
    //             })
    //             ->visible(fn (Warga $record) => $record->status == ConfirmStatus::Baru)
    //             ->color('success')
    //             ->icon('heroicon-o-check')
    //             ->requiresConfirmation(),
    //         Actions\Action::make('Tolak')
    //             ->action(function (Warga $record) {
    //                 $record->status = ConfirmStatus::Tolak;
    //                 $record->save();
    //             })
    //             ->visible(fn (Warga $record) => $record->status != ConfirmStatus::Tolak)
    //             ->color('danger')
    //             ->icon('heroicon-o-x-mark')
    //             ->requiresConfirmation(),
    //     ];
    // }
}
