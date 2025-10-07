<?php

namespace App\Livewire\Items;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use App\Models\Item;
use Livewire\Component;
use Filament\Forms\Components\FileUpload;

class EditItem extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Item $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Edit the Item')
                ->description('Update the item details as you wish')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                     ->label('Item Name'),
                    TextInput::make('sku'),
                    TextInput::make('price')
                        ->numeric()->prefix('ETB'),
                    ToggleButtons::make('status')
                    ->label('Is this Item Active?')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'In Active'
                    ])
                    ->grouped(),
                    FileUpload::make('image')
                ])
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()->title('Item Updated')->success()
            ->body("Item {$this->record->name} has been Updatd Successfully!")->send();
    }

    public function render(): View
    {
        return view('livewire.items.edit-item');
    }
}
