<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Answer;
use App\Models\Certification;
use App\Models\Domain;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizHeader;
use App\Models\Quote;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\HtmlString;

class UserQuiz extends Component implements HasForms
{
    use InteractsWithForms;
    public $quote='';
    public $domains = [];
    public $domain_id = '';
    public $difficulty = [];
    public $section_id = '';
    public $certification_id = '';
    public $userAnswered = '';
    public $quizPecentage = 0;
    public $currentQuizSize = 0;
    public $learningMode = false;
    public $quizHasEnded = false;
    public $quizInProgress = false;
    public $totalQuizQuestions = 0;
    public $currectQuizAnswers = 0;
    public $answeredQuestionId = '';
    public $answeredQuestions = [];
    public $quizQuestionCounter = 1;
    public $quizSetupInProgress = true;
    public $isUserAnswerCorrect = false;
    public Certification $certification;


    public ?Question $currentQuestion;
    public QuizHeader $currentquizHeader;


    public function mount(){
        $this->quote = Quote::where('is_active',true)->inRandomOrder()->first();

    }

    public function render(){

        return view('livewire.user-quiz');
    }

    public function initializeQuiz(): void{
        if($this->preQuizForm->validate()){
            $this->currentQuestion = $this->getNewQuestion();
            if( ! ($this->currentQuestion?->id === null)){
                $this->certification = Certification::where('id',$this->certification_id)->first();
                $this->currentquizHeader = QuizHeader::create([
                    'user_id' => auth()->id(),
                    'certification_id' => $this->certification_id,
                    'quiz_size' => $this->currentQuizSize,
                    'section_id' => $this->certification->section_id,
                    'domains' => $this->domains,
                    'difficulty' => $this->difficulty,
                    'learningmode' => $this->learningMode,
                ]);
                $this->quizSetupInProgress=false;
                $this->quizInProgress=true;
            }
            else{
                Notification::make()
                ->title('Quiz cannot be started!')
                ->warning()
                ->body('No questions are available with the given quiz conditions for the selected **certification**.')
                ->send();
            }
        }
    }

    public function startQuiz(){
        if($this->quizForm->getState()){
            $correctAnswer = Answer::where('question_id', $this->currentQuestion->id)
                                    ->where('is_checked',true)
                                    ->first();
            $userAnswered = Answer::where('question_id', $this->currentQuestion->id)
                                    ->where('id',$this->answeredQuestionId)
                                    ->first();

            $isAnswerCorrect = ($correctAnswer->id == $userAnswered->id)?true : false;

            Quiz::create([
                'user_id' => auth()->id(),
                'quiz_header_id' => $this->currentquizHeader->id,
                'section_id' => $this->certification->section_id,
                'question_id' => $this->currentQuestion->id,
                'domain_id' => $this->currentQuestion->domain->id,
                'certification_id' => $this->certification_id,
                'answer_id' => $this->answeredQuestionId,
                'is_correct' => $isAnswerCorrect,
            ]);

            $this->quizQuestionCounter++;
            if($this->quizQuestionCounter > $this->currentQuizSize){
                $this->showResults();
            }
            $this->currentquizHeader->questions_taken = $this->answeredQuestions;
            $this->currentquizHeader->save();
            $this->currentQuestion = $this->getNewQuestion();

        }

    }
    public function getNewQuestion(){

            $question = Question::whereIn('domain_id', $this->domains)
            ->whereIn('level', $this->difficulty)
            ->whereNotIn('id', $this->answeredQuestions)
            ->where('is_active',true)
            ->with(['answers' => function ($answers) {
                $answers->inRandomOrder()->get();
            }])
            ->inRandomOrder()
            ->first();

        if($question == null && $this->quizQuestionCounter > 1 ) {
            Log::info($question);
            $this->currentquizHeader->quiz_size = $this->quizQuestionCounter - 1;
            $this->currentquizHeader->save();
            $this->showResults();
        }
        if(!$question == null){
            array_push($this->answeredQuestions, $question->id);
        }
        return $question;
    }

    public function showResults(){
        $this->totalQuizQuestions = Quiz::where('quiz_header_id', $this->currentquizHeader->id)
            ->count();
        $this->currectQuizAnswers = Quiz::where('quiz_header_id', $this->currentquizHeader->id)
            ->where('is_correct', '1')
            ->count();

        $this->quizPecentage = round(($this->currectQuizAnswers / $this->totalQuizQuestions) * 100, 2);
        $this->currentquizHeader->questions_taken = $this->answeredQuestions;
        $this->currentquizHeader->completed = true;
        $this->currentquizHeader->score = $this->quizPecentage;
        $this->currentquizHeader->save();
        $this->quizInProgress = false;
        $this->quizHasEnded = true;
    }

    protected function getForms(): array{
        return [
            'preQuizForm',
            'quizForm',
        ];
    }



    public function preQuizForm(Form $form): Form
    {
    return $form
        ->schema([
            ComponentsSection::make('Quiz Configuration')
                ->schema([
                    Wizard::make([
                        Wizard\Step::make('Certification')
                            ->schema([
                                Select::make('certification_id')
                                ->label('Certification')
                                ->options(Certification::query()->where('is_active', true)->whereIn('id',Auth::user()
                                    ->certifications_owned()->pluck('id'))->pluck('name', 'id'))
                                    ->required()
                                    ->live()
                                    ->native(false),
                                Select::make('domains')
                                    ->label('Domains to Include')
                                    ->options(fn (Get $get): Collection => Domain::query()
                                        ->where('certification_id', $get('certification_id'))
                                        ->pluck('name', 'id'))
                                        ->required()
                                        ->multiple()
                                        ->live()
                                        ->native(false),
                            ]),
                        Wizard\Step::make('Quiz Mode (Learning / Live)')
                            ->schema([
                                Toggle::make('learningMode')
                                ->label('Learning Mode on?')
                                ->onColor('success')
                                ->offColor('gray'),

                                CheckboxList::make('difficulty')
                                ->label('Difficulty Level')
                                ->options([
                                    1 => 'Easy',
                                    2 => 'Medium',
                                    3 => 'Hard',
                                ])->columns(5)
                                ->required(),
                            ]),
                        Wizard\Step::make('Levels')
                            ->schema([
                                Select::make('currentQuizSize')
                                    ->label('Quiz Size')
                                    ->options([
                                        5 => '5',
                                        10 => '10',
                                        15 => '15',
                                    ])
                                    ->native(false),
                            ]),
                        ])->submitAction(new HtmlString('<button class="btn-primary" type="submit">Start Quiz</button>')),
                ]),
        ])
        ->model(QuizHeader::class);
}

    public function quizForm(Form $form): Form
    {
    return $form
        ->schema([
                Radio::make('answeredQuestionId')
                    ->label('Answers')
                    ->options(fn () => Answer::where('question_id',$this->currentQuestion->id)
                    ->pluck('answer','id'))
                    ->required(),
                    ])
                ->model(Quiz::class);
    }
}
