<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Points', number_format(7238))
                ->chart(
                    [100, 200, 10, 401, 30, 90]
                ),
            Stat::make('Claimable Equivalence', '$'.number_format(200, 2)),
            Stat::make('Claimed Points in USD', '$'.number_format(5200, 2)),
        ];
    }
}
