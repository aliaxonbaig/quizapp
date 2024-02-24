<?php
namespace App\Filament\Member\Widgets;

use App\Models\QuizHeader;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class UserQuizChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = QuizHeader::where('user_id', auth()->id())->pluck('score', 'id')->toArray();
        $quizNumbers = range(1, count($data)); // Generate sequential quiz numbers

        // Split the keys and values into separate arrays
        $scoreData = array_values($data);

        return [
            'datasets' => [
                [
                    'label' => 'Quiz Scores',
                    'data' => $scoreData,  // Use the 'scoreData' array for 'data'
                    'fill' => 'start',
                ],
            ],
            'labels' => $quizNumbers,  // Use sequential quiz numbers for 'labels'
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
