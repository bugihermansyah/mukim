<?php

namespace App\Filament\Pages\Settings;

use App\Models\Settings;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Pages\Page;
use Filament\Actions\{Action, ActionGroup};
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class General extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $model = Settings::class;

    protected static ?string $slug = 'settings/default';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings.general';

    protected static ?string $navigationGroup = 'Pengaturan';
    
    protected static ?int $navigationSort = 51;

    public ?array $data = [];

    public ?Settings $record = null;

    public function mount(): void
    {
        $this->record = Settings::firstOrNew([
            'code' => 'umum',
        ]);

        // abort_unless(static::canView($this->record), 404);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Rate limiting')
                    ->description('Prevent abuse by limiting the number of requests per period')
                    ->aside()
                    ->schema([
                        FileUpload::make('logo')
                            ->image()
                            ->maxSize(512)
                            ->openable()
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama')
                            ->helperText('Nama Perumahan / Cluster / Area / Lingkungan')
                            ->required(),
                        TextInput::make('address')
                            ->label('Alamat')
                            ->required(),
                ])
                ->collapsible(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
 
            Settings::where('code', 'umum')->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make() 
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
    
    // protected function handleRecordUpdate(Settings $record, array $data): Settings
    // {
    //     CompanyDefaultUpdated::dispatch($record, $data);

    //     $record->update($data);

    //     return $record;
    // }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::pages/tenancy/edit-tenant-profile.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }
}
