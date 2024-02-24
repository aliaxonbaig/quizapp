<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Http\Request;
class QuizDetailPage extends Page
{
    use HasPageShield;

    public $record;

    public function mount(Request $request){

        $this->record = $request->record;
    }

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';

    protected static ?string $title = 'Quiz Details';

    protected static string $view = 'filament.member.pages.quiz-detail-page';

    protected static bool $shouldRegisterNavigation = false;

}
