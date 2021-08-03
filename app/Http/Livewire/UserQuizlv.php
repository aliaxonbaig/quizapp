<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UserQuizlv extends Component
{
    public $totalQuizQuestions;
    public $currectQuizAnswers;
    public $quizPecentage;
    public $quizInProgress = true;
    public $showResult = false;
    public $sectionId;
    public $quizSize;
    public $currentQuestion;
    public $answeredQuestions = [];
    public $userAnswered = [];
    public $count = 0;
    public $quizid;

    public function showResults()
    {
        //Easy part, need a new view to display results and redirect maybe.
        $this->totalQuizQuestions = Quiz::where('quizid', $this->quizid)->count();
        $this->currectQuizAnswers = Quiz::where('quizid', $this->quizid)
            ->where('is_correct', '1')
            ->count();
        $this->quizPecentage = round(($this->currectQuizAnswers / $this->totalQuizQuestions) * 100, 2);
        $this->showResult = true;
        $this->quizInProgress = false;
    }
    public function render()
    {
        return view('livewire.user-quizlv');
    }

    public function mount()
    {
        $this->quizid = auth()->id() . '-' . time() . '-' . Str::random(12);
        $this->count = 1;
        $this->currentQuestion = $this->getNextQuestion();
    }

    public function getNextQuestion()
    {
        $question = Question::where('section_id', $this->sectionId)
            ->whereNotIn('id', $this->answeredQuestions)
            ->with('answers')
            ->inRandomOrder()
            ->first();
        if ($question === null) {
            return $this->showResults();
        }
        array_push($this->answeredQuestions, $question->id);
        return $question;
    }

    public function nextQuestion()
    {
        $storeQuestion = new Quiz();
        list($answerId, $isChoiceCorrect) = explode(',', $this->userAnswered[0]);
        $storeQuestion->user_id = auth()->id();
        $storeQuestion->quizid = $this->quizid;
        $storeQuestion->question_id = $this->currentQuestion->id;
        $storeQuestion->section_id = $this->currentQuestion->section_id;
        $storeQuestion->answer_id = $answerId;
        $storeQuestion->is_correct = $isChoiceCorrect;
        $storeQuestion->save();
        $this->count++;
        $answerId = '';
        $isChoiceCorrect = '';
        $this->reset('userAnswered');
        if ($this->count == $this->quizSize + 1) {
            $this->showResults();
        }
        $this->currentQuestion = $this->getNextQuestion();
    }
}
