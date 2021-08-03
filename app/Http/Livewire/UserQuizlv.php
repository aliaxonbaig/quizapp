<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use App\Models\Question;
use App\Models\QuizHeader;

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
        $this->totalQuizQuestions = Quiz::where('quiz_header_id', $this->quizid->id)->count();
        $this->currectQuizAnswers = Quiz::where('quiz_header_id', $this->quizid->id)
            ->where('is_correct', '1')
            ->count();
        $this->quizPecentage = round(($this->currectQuizAnswers / $this->totalQuizQuestions) * 100, 2);
        //$trackQuizStatus = QuizHeader::find($this->quizid->id)->first();

        $this->quizid->completed = true;
        $this->quizid->score = $this->quizPecentage;
        $this->quizid->save();
        $this->showResult = true;
        $this->quizInProgress = false;
    }
    public function render()
    {
        return view('livewire.user-quizlv');
    }

    public function mount()
    {
        $this->quizid = QuizHeader::create([
            'user_id' => auth()->id(),
            'quiz_size' => $this->quizSize,
        ]);
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
        // $trackQuizStatus = QuizHeader::where('id', $this->quizid->id)->first();
        $this->quizid->questions_taken = serialize($this->answeredQuestions);
        list($answerId, $isChoiceCorrect) = explode(',', $this->userAnswered[0]);
        Quiz::create([
            'user_id' => auth()->id(),
            'quiz_header_id' => $this->quizid->id,
            'section_id' => $this->currentQuestion->section_id,
            'question_id' => $this->currentQuestion->id,
            'answer_id' => $answerId,
            'is_correct' => $isChoiceCorrect
        ]);
        $this->quizid->save();
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
