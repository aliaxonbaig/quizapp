<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;

class UserQuizlv extends Component
{
    public $section_id;
    public $size;
    //public $userAnswer;
    public $currentQuestion;
    public $answeredQuestions = [];
    public $userAnswered = [];
    // public $userAnswerIsCorrect;
    //public $correctChoice;
    public $count = 0;
    public $quizid;

    public function showResults()
    {
        dd($this->answeredQuestions);
    }
    public function render()
    {
        return view('livewire.user-quizlv');
    }

    public function mount()
    {
        $this->quizid = auth()->id() . '-' . time() . '-' . Str::random(12);
        $this->count = 0;
        $this->currentQuestion = $this->getNextQuestion();
    }


    public function checkAnswer($answers)
    {
    }
    public function getNextQuestion()
    {
        $question = Question::where('section_id', $this->section_id)
            ->whereNotIn('id', $this->answeredQuestions)
            ->with('answers')
            ->inRandomOrder()
            ->first();
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
        if ($this->count == $this->size) {
            $this->showResults();
        }
        $this->currentQuestion = $this->getNextQuestion();
    }
}
