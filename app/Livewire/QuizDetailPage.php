<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\QuizHeader;
use Livewire\Component;

class QuizDetailPage extends Component
{
    public $record;
    public $userQuizDetails;
    public $usersResults;
    public $choice;


    public function mount($record)
    {
        $this->record = $record;
        $this->choice = collect(['A', 'B', 'C', 'D']);

        $this->userQuizDetails = QuizHeader::where('id', $this->record)
            ->with('section','certification')->first();

        $this->usersResults = Quiz::with(['question.answers' => function ($query) {
                $query->orderBy('id');
            }])
            ->where('quiz_header_id', '=', $this->userQuizDetails->id)
            //->Join('questions', 'quizzes.question_id', '=', 'questions.id')
            ->get();
    }

    public function render()
    {
        return view('livewire.quiz-detail-page');
    }

}
