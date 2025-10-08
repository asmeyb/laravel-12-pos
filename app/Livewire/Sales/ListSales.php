<?php

namespace App\Livewire\Sales;

use Filament\Actions\Action;
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
use Livewire\Component;
use App\Models\Sale;

class ListSales extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Sale::query())
            ->columns([
                TextColumn::make('customer.name')
                ->sortable(),
                TextColumn::make('saleItems.item.name')
                ->label('Sold Items')
                ->bulleted()
                ->limitList(2)
                ->expandableLimitedList(),
                TextColumn::make('total')
                ->money()
                ->sortable(),
                TextColumn::make('discount')
                ->money(),
                TextColumn::make('paid_amount')
                ->money(),
                TextColumn::make('paymentMethod.name'),
                TextColumn::make('soldBy.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('delete')
                ->requiresConfirmation()
                ->color('danger')
                ->action(fn (Sale $record) => $record->delete())
                ->successNotification(
                     Notification::make()
                        ->title('Sale Deleted successfully')
                        ->success()
                        )
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.sales.list-sales');
    }
}
