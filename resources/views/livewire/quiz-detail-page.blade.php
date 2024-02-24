<div>
    <div class="bg-white border-2 border-gray-300 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-xl leading-6 font-medium text-gray-900">
                Quiz Information
            </h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-700">
                You took this quiz {{$userQuizDetails->updated_at->diffForHumans()}} on <span class="text-bold bg-green-200 p-2 rounded-lg"> {{$userQuizDetails->updated_at}} </span>
            </p>
        </div>
        <div class="border-t border-gray-300">
            <dl>
                <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Section Title
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$userQuizDetails->section->name}}
                        <p class="mt-1 max-w-2xl text-sm text-gray-700">
                            {{$userQuizDetails->section->description}}
                        </p>
                    </dd>
                </div>
                <div class="bg-gray-100 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Certification Title
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$userQuizDetails->certification->name}}
                        <p class="mt-1 max-w-2xl text-sm text-gray-700">
                            {{$userQuizDetails->certification->description}}
                        </p>
                    </dd>
                </div>
                <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Quiz Completion Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$userQuizDetails->completed ? 'Completed' : 'Not Completed'}}
                    </dd>
                </div>
                <div class="bg-gray-100 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Total Quiz Questions
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$userQuizDetails->quiz_size}}
                    </dd>
                </div>
                <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Quiz Mode
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{$userQuizDetails->learningmode ? 'Learning Mode' : 'Quiz Mode'}}
                    </dd>
                </div>
                <div class="bg-gray-100 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Quiz Score
                    </dt>
                    @if($userQuizDetails->score < 70)
                        <dd>
                        <x-answerIconWrong>
                            {{$userQuizDetails->score .' %'}}
                        </x-answerIconWrong>
                        </dd>
                    @else
                    <x-answerIconCorrect>
                        {{$userQuizDetails->score .' %'}}
                    </x-answerIconCorrect>
                    @endif
                </div>
                <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
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
    @foreach($usersResults as $userResult)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
            <div class="px-4 py-5 sm:px-6">
                @if($userResult->is_correct === 1)
                    <x-answerIconCorrect>
                        You Answered Correct
                    </x-answerIconCorrect>
                @else
                    <x-answerIconWrong>
                        You Answered Wrong
                    </x-answerIconWrong>
                @endif
                @if($userResult->question->getMedia('questions')->first())
                <x-displayImage>
                    <img alt="Section Image" src="{{ $userResult->question->getMedia('questions')->first()->getUrl() }}"
                    class="h-full w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />
                </x-displayImage>
                @endif
                <h3 class="my-2 text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="mr-2"> {{$loop->iteration}}</span> {!! nl2br(e($userResult->question->question))  !!}
                </h3>
                <ul class="text-gray-800 font-light">
                    @foreach($userResult->question->answers as $key => $answer)
                        @if($userResult->is_correct && $userResult->answer_id === $answer->id)
                            <div class="mt-1 py-1 max-w-auto sm:text-sm lg:text-lg px-2 rounded-lg bg-none bg-green-100">
                                <span class="mr-2 ">{{$choice->values()->get($key)}} </span> {{$answer->answer}}
                            </div>
                        @elseif( ! $userResult->is_correct  && ( $userResult->answer_id === $answer->id))
                            <div class="mt-1 py-1 max-w-auto px-2 rounded-lg bg-red-100">
                                <span class="mr-2 ">{{$choice->values()->get($key)}} </span> {{$answer->answer}} <span class="p-1">(Your selection)</span>
                            </div>
                        @elseif(($answer->is_checked) && (!$userResult->question->is_correct))
                            <div class="mt-1 py-1 max-w-auto px-2 rounded-lg bg-green-100">
                                <span class="mr-2 ">{{$choice->values()->get($key)}} </span> {{$answer->answer}} <span class="p-1">(Correct Answer)</span>
                            </div>
                        @else
                            <div class="mt-1 py-1 max-w-auto  px-2 rounded-lg  ">
                                <span class="mr-2 ">{{$choice->values()->get($key)}} </span> {{$answer->answer}}
                            </div>
                        @endif
                    @endforeach
                </ul>
                <x-explanation>
                    {!! nl2br(e($userResult->question->explanation)) !!}
                </x-explanation>
            </div>
        </div>
    @endforeach
</div>
