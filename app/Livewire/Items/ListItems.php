<?php

namespace App\Livewire\Items;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Item;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;

class ListItems extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Item::query())
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('sku')->sortable(),
                TextColumn::make('price')->money('ETB'),
                TextColumn::make('status')->badge()
                        ->color(fn (string $state): string => match ($state) {
                                'inactive' => 'warning',
                                'active' => 'success',
                                }),
                ImageColumn::make('image')
                ->circular(),
                TextColumn::make('creator.name')
                     ->label('Created By')
                     ->sortable()
                     ->searchable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                ->label('Add New')
                ->url(fn (): string => route('items.create'))
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn (Item $record) => $record->delete())
                    ->successNotification(
                        Notification::make()->title('Item Deleted Successfully')
                        ->success(), 
                    ),
                    Action::make('edit')
                        ->url(fn (Item $record): string => route('item.update', $record))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.items.list-items');
    }
}
