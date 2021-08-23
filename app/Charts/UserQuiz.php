<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserQuiz extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $quizScores = auth()
            ->user()
            ->quizHeaders()
            ->select('id', 'score')
            ->orderBy('created_at', 'asc')
            ->take(30)
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
