<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Deatil') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <!-- QUIZ HEADER START -->

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Quiz Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    You took this quiz {{$userQuizDetails->updated_at->diffForHumans()}}
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Section Title
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$userQuizDetails->section->name}}
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{$userQuizDetails->section->description}}
                            </p>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Quiz Completion Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$userQuizDetails->completed ? 'Completed' : 'Not Completed'}}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Total Quiz Questions
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$userQuizDetails->quiz_size}}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Quiz Score
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 bg-green-200 rounded-lg">
                            {{$userQuizDetails->score .'%'}}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Quiz Duration
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$userQuizDetails->updated_at->diffInMinutes($userQuizDetails->created_at) .' Minutes'}}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- QUIZ HEADER END -->
        @foreach($quizQuestions as $key => $question)
        @php
        $userAnswer = $userQuiz[$key];
        @endphp
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-2">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 mb-2 font-medium text-gray-900">
                    <span class="mr-2 font-extrabold"> {{$key + 1}}</span> {{$question->question}}
                    <div>
                        <span class="block text-sm ">Explanation</span>
                        <span class="block bg-green-100 text-xs my-2 p-4">{{$question->explanation}}</span>
                    </div>
                </h3>
                @foreach($question->answers as $key => $answer)
                @if(($userAnswer->is_correct==='1') && ($answer->is_checked ==='1'))
                <div class="mt-1 max-w-auto text-sm px-2 rounded-lg text-white bg-none bg-green-500">
                    <span class="mr-2 font-extrabold">{{$choice->values()->get($key)}} </span> {{$answer->answer}}
                </div>
                @elseif(($userAnswer->answer_id === $answer->id) && ($answer->is_checked === '0'))
                <div class="mt-1 max-w-auto text-sm px-2 rounded-lg text-white bg-red-600 font-extrabold ">
                    <span class="mr-2 font-extrabold">{{$choice->values()->get($key)}} </span> {{$answer->answer}}
                </div>
                @elseif($answer->is_checked && $userAnswer->is_correct === '0')
                <div class="mt-1 max-w-auto text-sm px-2 rounded-lg text-white bg-green-500 font-extrabold ">
                    <span class="mr-2 font-extrabold">{{$choice->values()->get($key)}} Correct Answer: </span> {{$answer->answer}}
                </div>
                @else
                <div class="mt-1 max-w-auto text-sm px-2 rounded-lg text-gray-500 font-extrabold ">
                    <span class="mr-2 font-extrabold">{{$choice->values()->get($key)}} </span> {{$answer->answer}}
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>