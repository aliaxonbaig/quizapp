<?php

namespace App\Filament\Widgets;

use App\Models\QuizHeader;
use App\Models\User;
use Filament\Widgets\ChartWidget;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminQuizQstnStatsWidget extends ChartWidget
{
    use HasWidgetShield;


    protected static ?string $heading = 'Global Stats';

    // protected static ?string $maxHeight = '250px';

    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $data1 = Trend::model(User::class)
        ->between(
            start: now()->subDays(15),
            end: now()->addDays(1),
        )
        ->perDay()
        ->count();

        $data2= Trend::model(QuizHeader::class)
        ->between(
            start: now()->subDays(15),
            end: now()->addDays(1),
        )
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Users',
                'data' => $data1->map(fn (TrendValue $value) => $value->aggregate),
                'fill' => 'start',
                'type' => 'line',
                // 'backgroundColor' => '#F48225',
                // 'borderColor' => '#F48225'
            ],
            [
                'label' => 'Quizzes',
                'data' => $data2->map(fn (TrendValue $value) => $value->aggregate),
                'fill' => 'start',
                'type' => 'line',
                // 'backgroundColor' => '#F48225',
                // 'borderColor' => '#F48225'
            ],
        ],
        'labels' => $data1->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
