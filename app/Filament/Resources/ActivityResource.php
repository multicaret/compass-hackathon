<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                                          ->required()
                                          ->maxLength(255),
                Forms\Components\Textarea::make('description')
                                         ->required()
                                         ->columnSpanFull(),
                Forms\Components\TextInput::make('location')
                                          ->required()
                                          ->maxLength(255),
                Forms\Components\Select::make('type')
                                       ->options(['physical', 'online'])
                                       ->required(),
                Forms\Components\TextInput::make('compass_points')
                                          ->required()
                                          ->maxLength(255),
                Forms\Components\Toggle::make('is_used')
                                       ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                                               ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                                               ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'sm' => 2,
                'md' => 2,
                'xl' => 4,
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('img')
                                             ->getStateUsing(function (Activity $record): string {
                                                 $url = '/images/activities/img'.$record->id.'.jpg';

                                                 return "<img src='".$url."' style='height:300px;width:100%;object-fit:cover'/>";
                                             })
                                             ->html()
                                             ->grow(true),
                    Tables\Columns\TextColumn::make('title')
                                             ->weight(FontWeight::Bold)
                                             ->searchable(),
                    Tables\Columns\TextColumn::make('location')
                                             ->searchable(),
                    Tables\Columns\TextColumn::make('type')
                                             ->badge()
                                             ->color(fn(string $state): string => match ($state) {
                                                 'physical' => 'warning',
                                                 'online' => 'success',
                                             }),
                    Tables\Columns\TextColumn::make('compass_points')
                                             ->getStateUsing(function (Activity $record): string {
                                                 $url = '/images/coin.png';

                                                 return "<div style='display:flex; margin-top:20px'><img src='".$url."' style='height:25px;width:25px;object-fit:cover;margin-right:5px'/>".$record->compass_points."</div>";
                                             })
                                             ->html(),
                    Tables\Columns\IconColumn::make('is_used')
                                             ->boolean()
                                             ->tooltip('Is Used or Not'),
                    Tables\Columns\TextColumn::make('start_date')
                                             ->dateTime()
                                             ->sortable(),
                    Tables\Columns\TextColumn::make('end_date')
                                             ->dateTime()
                                             ->sortable(),
                ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                /*Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),*/
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageActivities::route('/'),
        ];
    }
}
