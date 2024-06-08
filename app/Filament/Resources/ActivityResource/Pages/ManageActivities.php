<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\Activity;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;

class ManageActivities extends ManageRecords
{
    protected static string $resource = ActivityResource::class;


    public function getTabs(): array
    {
        $physicalCount = Activity::where('type', 'physical')
                                 ->count();

        $onlineCount = Activity::where('type', 'online')
                               ->count();

        return [
            'Physical' => Tab::make('Physical')
                             ->icon('heroicon-o-building-library')
                             ->query(fn($query) => $query->where('type', 'physical'))
                             ->badge($physicalCount),
            'Online' => Tab::make('Online')
                           ->icon('heroicon-o-wifi')
                           ->query(fn($query) => $query->where('type', 'online'))
                           ->badge($onlineCount),
            'all' => Tab::make('All')
                        ->icon('heroicon-o-trophy')
                        ->badge($physicalCount + $onlineCount),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
