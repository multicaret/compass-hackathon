<?php

namespace App\Filament\Widgets;

use App\Enums\MediaCoverEnum;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TransactionsTableWidget extends BaseWidget
{

    protected static ?string $heading = 'Latest Transactions';

    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        $builder = Transaction::query();

        return $table
            ->query($builder)
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('type')
                                         ->badge()
                                         ->color(fn(string $state): string => match ($state) {
                                             'in' => 'success',
                                             'out' => 'danger',
                                         })
                                         ->formatStateUsing(fn(string $state): string => strtoupper($state)),
                Tables\Columns\TextColumn::make('title')
                                         ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('description')
                                         ->weight(FontWeight::ExtraLight)
                                         ->limit(40),
                Tables\Columns\TextColumn::make('created_at')
                                         ->label('Transaction Date')
                                         ->date(),
            ])
            ->actions([
            ]);
    }
}
