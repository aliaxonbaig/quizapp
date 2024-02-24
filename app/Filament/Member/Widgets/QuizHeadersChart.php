<?php

namespace App\Filament\Member\Widgets;

use App\Models\Quiz;
use App\Models\QuizHeader;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class QuizHeadersChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 4;

    // protected function getData(): array
    // {
    //     $data = QuizHeader::where('user_id', auth()->id())->pluck('score', 'id')->toArray();

    //     // Split the keys and values into separate arrays
    //     $scoreData = array_values($data);
    //     $labelData = array_keys($data);

    //     return [
    //         'datasets' => [
    //             [
    //                 'label' => 'Quiz Scores',
    //                 'data' => $scoreData,  // Use the 'scoreData' array for 'data'
    //             ],
    //         ],
    //         'labels' => $labelData,  // Use the 'labelData' array for 'labels'
    //     ];
    // }

    protected function getData(): array
    {
    $data = Trend::query(QuizHeader::where('user_id', auth()->id()))
        ->between(
            start: now()->subDays(15),
            end: now()->addDays(15),
        )
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Daily Quizzes',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'fill' => 'start',
                'type' => 'bar',
                'backgroundColor' => '#36A2EB',
                'borderColor' => '#9BD0F5'

            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];


    }
    protected function getType(): string
    {
        return 'bar';
    }
}
