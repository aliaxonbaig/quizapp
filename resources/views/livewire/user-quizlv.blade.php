<div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">

    <!-- Start of quiz box -->
    @if($quizInProgress)
    <div class="px-4 -py-3 sm:px-6 ">
        <div class="flex max-w-auto justify-between">
            <h1 class="text-sm leading-6 font-medium text-gray-900">
                <span class="text-gray-400 font-extrabold p-1">User</span>
                <span class="font-bold p-2 leading-loose bg-blue-500 text-white rounded-lg">{{Auth::user()->name}}</span>
            </h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                <span class="text-gray-400 font-extrabold p-1">Quiz Progress </span>
                <span class="font-bold p-3 leading-loose bg-blue-500 text-white rounded-full">{{$count .'/'. $quizSize}}</span>
            </p>
        </div>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
        <form wire:submit.prevent>
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 mb-2 font-medium text-gray-900">
                    <span class="mr-2 font-extrabold"> {{$count}}</span> {{$currentQuestion->question}}
                    @if($learningMode)
                    <div x-data={show:false} class="block text-xs">
                        <div class="p-1" id="headingOne">
                            <button @click="show=!show" class="underline text-blue-500 hover:text-blue-700 focus:outline-none text-xs px-3" type="button">
                                Explanation
                            </button>
                        </div>
                        <div x-show="show" class="block p-2 bg-green-100 text-xs">
                            {{$currentQuestion->explanation}}
                        </div>
                    </div>
                    @endif
                </h3>
                @foreach($currentQuestion->answers as $answer)
                <label for="question-{{$answer->id}}">
                    <div class="max-w-auto px-3 py-3 m-3 text-gray-800 rounded-lg border-2 border-gray-300 text-sm ">
                        <span class="mr-2 font-extrabold"><input id="question-{{$answer->id}}" value="{{$answer->id .','.$answer->is_checked}}" wire:model="userAnswered" type="checkbox"> </span> {{$answer->answer}}
                    </div>
                </label>
                @endforeach
            </div>
            <div class="flex items-center justify-end mt-4">
                @if($count < $quizSize) <button wire:click="nextQuestion" type="submit" @if($isDisabled) disabled='disabled' @endif class="m-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    {{ __('Next Question') }}
                    </button>
                    @else
                    <button wire:click="nextQuestion" type="submit" @if($isDisabled) disabled='disabled' @endif class="m-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        {{ __('Show Results') }}
                    </button>
                    @endif
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