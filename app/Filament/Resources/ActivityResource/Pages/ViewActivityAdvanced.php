<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\Activity;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewActivityAdvanced extends ViewRecord
{

    public string|int|null|\Illuminate\Database\Eloquent\Model $record;
    protected static string $resource = ActivityResource::class;


    public function getTitle(): string|Htmlable
    {
        return $this->record->title.' Activity';
    }

    public function getSubheading(): string|Htmlable
    {
        return $this->record->start_date->addMonths(mt_rand(1, 9))->ago();
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('qr_code')
                          ->label('Scan QR code')
                          ->action(function ($record): void {
                              /*Notification::make()
                                          ->success()
                                          ->title('Work in progress, Sorry not enough time!')
                                          ->send();*/
                          })
                          ->hidden(function ($record): bool {
                              return $record->type == 'physical';
                          }),
            Actions\Action::make('twitch_stream')
                          ->label('Twitch Stream')
                          ->action(function ($record) {
                              return redirect('https://www.twitch.tv/search?term=CSGO');
                          })
                          ->hidden(function ($record): bool {
                              return $record->type == 'online';
                          }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('image')
                         ->hiddenLabel()
                         ->getStateUsing(function (Activity $record): string {
                             $url = '/images/activities/img'.$record->id.'.jpg';

                             return "<img src='".$url."' style='height:300px;width:100%;object-fit:cover;margin-right:5px'/>";
                         })
                         ->html()
                         ->columnSpanFull(),
                TextEntry::make('title')
                         ->columnSpanFull(),
                TextEntry::make('description')
                         ->columnSpanFull(),
                TextEntry::make('location'),
                TextEntry::make('type')
                         ->badge()
                         ->color(fn(string $state): string => match ($state) {
                             'physical' => 'warning',
                             'online' => 'success',
                         }),
                TextEntry::make('compass_points')
                         ->getStateUsing(function (Activity $record): string {
                             $url = '/images/coin.png';

                             return "<div style='display:flex; margin-top:20px'><img src='".$url."' style='height:25px;width:25px;object-fit:cover;margin-right:5px'/>".$record->compass_points.'</div>';
                         })
                         ->html(),

            ]);
    }
}
