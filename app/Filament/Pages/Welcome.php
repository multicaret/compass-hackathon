<?php

namespace App\Filament\Pages;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Team;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Welcome extends Page
{
    use InteractsWithForms;

    protected static ?string $title = 'Getting Started';
    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';
    protected static string $view = 'filament.pages.welcome';

    protected ?string $subheading = 'Join the excitement 🤩';

    public ?array $data = [];

    public function mount()
    {
        $auth = auth()->user();

        $this->form->fill([
            'foo' => 'bar',
        ]);
    }

    public function form(Form $form): Form
    {
        $types = collect();


        $hr = Placeholder::make('No Label')
                         ->hiddenLabel()
                         ->columnSpanFull()
                         ->content(new HtmlString('<hr>'));

        $genres = Genre::all();


        $allTeams = Team::all();
        $teams = collect();
        foreach ($allTeams as $team) {
            $icon = '<img src="/images/teams/'.$team->title.'.png" style="object-fit:contain" class="w-10 h-10 mr-5">';
            $badge = '';
            $text = '<div class="flex flex-col justify-center">
               <div class="font-bold text-start">'.$team->title.$badge.'</div>
               <div class="text-gray-500 text-start">'.$team->description.'</div>
             </div>';

            $html = '<div class="flex items-center">'.$icon.$text.'</div>';
            $teams->push([
                'id' => $team->id,
                'label' => $html,
            ]);
        }

        $allGames = Game::all();
        $games = collect();
        foreach ($allGames as $game) {
            $icon = '<img src="/images/games/'.$game->title.'.png" style="object-fit:contain;margin-right:10px" class="w-10 h-10 my-5">';
            $badge = '<span class="bg-green-100 text-green-800 text-xs font-medium ms-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Players: '.$game->yearly_players.'</span>';
            $text = '<div class="flex flex-col justify-center">
               <div class="font-bold text-start">'.$game->title.$badge.'</div>
               <div class="text-gray-500 text-start">'.$game->description.'</div>
             </div>';

            $html = '<div class="flex items-center">'.$icon.$text.'</div>';
            $games->push([
                'id' => $game->id,
                'label' => $html,
            ]);
        }

        return $form
            ->schema([
                Wizard::make()
                      ->submitAction(
                          (new HtmlString(Blade::render(
                              <<<BLADE
                            <x-filament::button type="submit">
                                Submit
                            </x-filament::button>
                            BLADE
                          )))
                      )
                      ->persistStepInQueryString()
                      ->skippable()
                      ->schema([
                          Wizard\Step::make('Genre')
                                     ->label('Genres')
                                     ->description('What do you prefer?')
                                     ->icon('heroicon-o-tag')
                                     ->schema([
                                         /*Placeholder::make('No Label')
                                                    ->hiddenLabel()
                                                    ->content(new HtmlString(
                                                        <<<'HTML'
                                                    <div class="text-center p-4 mb-1 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-300" role="alert">
                                                      These details are private and will not be shared.
                                                    </div>
                                                HTML
                                                    )),*/
                                         Select::make('genre')
                                               ->label('Choose your preferred genre')
                                               ->multiple()
                                               ->required()
                                               ->hintIcon('heroicon-o-question-mark-circle',
                                                   'You can change these preferences later in your profile.')
                                               ->native(false)
                                               ->options($genres->pluck('title', 'id'))
                                               ->allowHtml(),
                                     ]),
                          Wizard\Step::make('Teams')
                                     ->label('Teams')
                                     ->description('What are your favourite teams?')
                                     ->icon('heroicon-o-users')
                                     ->schema([

                                         Select::make('team')
                                               ->label('Which team is the closest to your heart?')
                                               ->required()
                                               ->multiple()
                                               ->hintIcon('heroicon-o-question-mark-circle',
                                                   'Remember to scroll inside the list and select the best team.')
                                               ->native(false)
                                               ->options($teams->pluck('label', 'id'))
                                               ->allowHtml(),

                                         Placeholder::make('No Label')
                                                    ->hiddenLabel()
                                                    ->content(new HtmlString(
                                                        <<<'HTML'
                                                            <div class="text-sm text-gray-500" role="alert">
                                                              <i>You can change all of these settings later from your profile.</i>
                                                            </div>
                                                        HTML
                                                    )),
                                     ]),
                          Wizard\Step::make('Games')
                                     ->label('Games')
                                     ->description('What are your favourite game?')
                                     ->icon('heroicon-o-bug-ant')
                                     ->schema([

                                         Select::make('game')
                                               ->label('Which game is the closest to your heart?')
                                               ->required()
                                               ->multiple()
                                               ->hintIcon('heroicon-o-question-mark-circle',
                                                   'Remember to scroll inside the list and select the best team.')
                                               ->native(false)
                                               ->options($games->pluck('label', 'id'))
                                               ->allowHtml(),

                                         Placeholder::make('No Label')
                                                    ->hiddenLabel()
                                                    ->content(new HtmlString(
                                                        <<<'HTML'
                                                            <div class="text-sm text-gray-500" role="alert">
                                                              <i>You can change all of these settings later from your profile.</i>
                                                            </div>
                                                        HTML
                                                    )),
                                     ]),
                      ]),
            ])
            ->statePath('data');
    }
}
