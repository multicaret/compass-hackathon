<?php

namespace App\Filament\Pages;

use App\Models\Genre;
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
