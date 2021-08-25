<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\QuizHeader;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;

class GlobalQuizzes extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $quizScores = QuizHeader::select('id', 'score')
            ->orderBy('created_at', 'asc')
            ->take(100)
            ->get();

        $scores = [];
        $ids = [];
        foreach ($quizScores as $score) {
            array_push($scores, $score->score);
            array_push($ids, $score->id);
        }

        return Chartisan::build()
            ->labels($ids)
            ->dataset('Score', $scores);
    }
}
