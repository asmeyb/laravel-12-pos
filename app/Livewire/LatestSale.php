<?php

namespace App\Livewire;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Sale;

class LatestSale extends TableWidget
{
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
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
