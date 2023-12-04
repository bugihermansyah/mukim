<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Enums\ConfirmStatus;
use App\Filament\Resources\WargaResource;
use App\Models\Warga;
use EightyNine\Approvals\Models\ApprovableModel;
use EightyNine\Approvals\Traits\HasApprovalHeaderActions;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use EightyNine\Approvals\Forms\Actions\ApproveAction;
use EightyNine\Approvals\Forms\Actions\DiscardAction;
use EightyNine\Approvals\Forms\Actions\RejectAction;
use EightyNine\Approvals\Forms\Actions\SubmitAction;

class ViewWarga extends ViewRecord
{
    use  HasApprovalHeaderActions;

    protected static string $resource = WargaResource::class;

    protected function getOnCompletionAction(): Action
    {
        return 
            Action::make("Done")
                ->color("success");
                // ->hidden(fn(ApprovableModel $record)=> $record->shouldBeHidden());
    }

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
