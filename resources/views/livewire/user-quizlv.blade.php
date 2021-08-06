<div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">

    <!-- Start of quiz box -->
    @if($quizInProgress)

    <div class="bg-white rounded-lg shadow-lg p-2 sm:p-4">
        <div class="text-center">
            <h2 class="text-2xl tracking-tight leading-10 font-extrabold text-gray-900 md:text-3xl sm:leading-none">
                User Name: <span class="text-indigo-600 ml-2"> {{Auth::user()->name.'!'}} </span>
            </h2>
            <p class="text-md mt-10"> Quiz Progress: <span class="font-extrabold text-blue-600 mr-2"> {{$count .'/'. $quizSize}} </span> </p>
        </div>
        <form wire:submit.prevent="">
            @csrf
            <div class="md:grid grid-cols-1 mt-10 justify-center gap-5">
                <div class="m-3  min-w-full mx-auto">
                    <p class="tracking-wide font-bold rounded border-2 border-blue-500 bg-blue-500 text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold pr-2">{{$count}}</span><span> {{$currentQuestion->question}}</span>
                    </p>
                </div>
                @foreach($currentQuestion->answers as $answer)
                <div class="m-3  min-w-full mx-auto">
                    <label for="question-{{$answer->id}}">
                        <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                            <span class="mx-auto font-extrabold text-blue-800 pr-2"><input id="question-{{$answer->id}}" value="{{$answer->id .','.$answer->is_checked}}" wire:model="userAnswered" type="checkbox"></span><span> {{$answer->answer}}</span>
                        </p>
                    </label>
                </div>
                @endforeach
                <div class="flex items-center justify-end mt-4">
                    @if($count < $quizSize) <x-jet-button wire:click="nextQuestion" type="submit" class="ml-4">
                        {{ __('Next Question') }}
                        </x-jet-button>
                        @else
                        <x-jet-button wire:click="nextQuestion" type="submit" class="ml-4">
                            {{ __('Show Results') }}
                        </x-jet-button>
                        @endif
                </div>
            </div>
        </form>
    </div>
    @endif
    <!-- end of quiz box -->

    @if($showResult)
    <div class="bg-indego-100 rounded-lg shadow-lg p-5 md:p-20 mx-2">
        <div class="text-center">
            <h2 class="text-2xl tracking-tight leading-10 font-extrabold text-gray-900 md:text-3xl sm:leading-none">
                Quiz<span class="text-indigo-600 ml-2">Result</span>
            </h2>
            <p class="text-md mt-10"> Dear <span class="font-extrabold text-blue-600 mr-2"> {{Auth::user()->name.'!'}} </span> You have secured </p>
            <div class="justify-center">
                <progress class="max-w-full mx-auto mr-1" id="quiz-{{$quizid}}" value="{{$quizPecentage}}" max="100"> {{$quizPecentage}} </progress> <span> {{$quizPecentage}}% </span>
            </div>
        </div>
        <div class="md:grid grid-cols-3 mt-10 justify-center gap-5">
            <div class="m-3  min-w-full mx-auto">
                <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                    <span class="mx-auto font-extrabold text-blue-800 pr-2">{{$totalQuizQuestions}}</span><span> Total Questions</span>
                </p>
            </div>
            <div class="m-3  min-w-full mx-auto">
                <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                    <span class="mx-auto font-extrabold text-blue-800 pr-2">{{$currectQuizAnswers}}</span><span> Correct Answers</span>
                </p>
            </div>
            <div class="m-3  min-w-full mx-auto justify-center">
                <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                    <span class="mx-auto font-extrabold text-blue-800 pr-2">{{$quizPecentage}}</span><span> Percentage</span>
                </p>
            </div>
        </div>
        <div class="m-3 justify-end p-3 mx-auto">
            <a href="{{route('userQuizHome')}}" class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                View your Quiz Histry
            </a>
        </div>
    </div>
    @endif
</div>