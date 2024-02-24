<?php

namespace App\Filament\Member\Widgets;

use App\Models\QuizHeader;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class StatsOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 2;

    //protected int | string | array $columnSpan = 2;

    protected function getStats(): array
    {

        return [

            Stat::make('Total Quizzes', QuizHeader::where('user_id', auth()->id())->count())
            ->color('success')
            ->chart(QuizHeader::where('user_id', auth()->id())->pluck('score')->toArray())
            ->url(route('filament.member.resources.my-quizzes.index')),

            Stat::make('Highiest Quiz Score', QuizHeader::where('user_id', auth()->id())->max('score'))
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),

            Stat::make('Lowest Quiz Score', QuizHeader::where('user_id', auth()->id())->min('score'))
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),

            Stat::make('Average Quiz Score', \number_format(QuizHeader::where('user_id', auth()->id())->avg('score'),2))
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
        ];
    }
}
