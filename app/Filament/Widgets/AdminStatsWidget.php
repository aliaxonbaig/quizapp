<?php

namespace App\Filament\Widgets;

use App\Models\QuizHeader;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AdminStatsWidget extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'User Growth';

    protected static ?int $sort = 5;

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
                // 'backgroundColor' => '#36A2EB',
                // 'borderColor' => '#9BD0F5'
            ],
            [
                'label' => 'Quizzes',
                'data' => $data2->map(fn (TrendValue $value) => $value->aggregate),
                'fill' => 'start',
                'type' => 'line',
                // 'backgroundColor' => '#46A2FB',
                // 'borderColor' => '#4BD0F5'
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
