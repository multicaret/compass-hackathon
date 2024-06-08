<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OverviewWidget;
use App\Filament\Widgets\TransactionsTableWidget;
use Filament\Pages\Page;

class Wallet extends Page
{

    protected static ?string $title = 'Wallet';
    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static string $view = 'filament.pages.wallet';

    protected static ?int $navigationSort = 10;

    protected ?string $subheading = 'Nice earnings 🥳';


    public function getFooterWidgets(): array
    {
        return [
            OverviewWidget::class,
            TransactionsTableWidget::class,
        ];
    }

}
