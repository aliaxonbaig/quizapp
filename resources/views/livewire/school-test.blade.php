<div>
    {{-- Test Setup Form --}}
    @if($quizSetupInProgress)
    <div class="rounded-lg">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>School Test Mode:</strong> This is a supervised exam. Learning mode is disabled - you won't see explanations or correct answers during the test.
                    </p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="initializeTest">
            {{ $this->preTestForm }}
            <x-filament-actions::modals />
        </form>
    </div>
    @endif

    {{-- Test In Progress --}}
    @if($quizInProgress)
    <div class="px-4 py-3 sm:px-6">
        <div class="flex max-w-auto justify-between p-6 bg-red-50 rounded-lg border-2 border-red-200">
            <div>
                <h1 class="text-sm leading-6 font-medium text-gray-900">
                    <span class="text-red-600 font-extrabold">⚠️ EXAM MODE</span>
                </h1>
                <p class="text-xs text-gray-600 mt-1">{{ $testName }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">
                    <span class="text-gray-400 font-extrabold">Student:</span>
                    <span class="font-bold px-2 py-1 bg-blue-500 text-white rounded-lg">{{Auth::user()->name}}</span>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">
                    <span class="text-gray-400 font-extrabold">Progress:</span>
                    <span class="font-bold px-3 py-1 bg-green-500 text-white rounded-full">{{$quizQuestionCounter}}/{{$currentQuizSize}}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 mb-2 font-medium text-gray-900">
                <span class="mr-2 font-extrabold text-blue-600">Q{{$quizQuestionCounter}}.</span> 
                {!! nl2br(e($currentQuestion->question)) !!}
            </h3>
            @if($currentQuestion->getMedia('questions')->first())
            <div class="mt-4">
                <img alt="Question Image" 
                     src="{{ $currentQuestion->getMedia('questions')->first()->getUrl() }}"
                     class="max-w-lg rounded-xl shadow-lg" />
            </div>
            @endif
        </div>

        <div class="p-10">
            <form wire:submit.prevent="startTest">
                {{ $this->testForm }}
                <div class="mt-10">
                    <x-filament::button type="submit" size="lg" color="primary">
                        {{ $quizQuestionCounter < $currentQuizSize ? 'Next Question →' : 'Finish Test' }}
                    </x-filament::button>
                </div>
            </form>
            <x-filament-actions::modals />
        </div>
    </div>
    @endif

    {{-- Test Results --}}
    @if($quizHasEnded)
    <section class="text-gray-600 body-font">
        <div class="bg-white border-2 border-gray-300 shadow overflow-hidden sm:rounded-lg">
            <div class="container px-5 py-5 mx-auto">
                <div class="text-center mb-5 justify-center">
                    <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
                        Test Results
                    </h1>
                    <p class="text-lg mt-4 mb-2"><strong>{{ $testName }}</strong></p>
                    <p class="text-md mt-2">
                        Dear <span class="font-extrabold text-blue-600">{{Auth::user()->name}}</span>, 
                        you have completed the test!
                    </p>
                    
                    <div class="mt-6 max-w-md mx-auto">
                        <span id="ProgressLabel" class="sr-only">Test Score</span>
                        <span role="progressbar" aria-valuenow="{{$quizPecentage}}" class="block rounded-full bg-gray-200">
                            <span class="block h-6 rounded-full {{ $quizPecentage >= 70 ? 'bg-green-600' : 'bg-red-600' }} text-center text-sm leading-6"
                                  style="width: {{$quizPecentage}}%">
                                <span class="rounded-sm bg-white px-2 font-bold {{ $quizPecentage >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                    {{$quizPecentage}}%
                                </span>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                 stroke-width="3" class="text-green-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Correct Answers</span>
                            <span class="title-font font-medium text-lg">{{$currectQuizAnswers}}</span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                 stroke-width="3" class="text-blue-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Total Questions</span>
                            <span class="title-font font-medium text-lg">{{$totalQuizQuestions}}</span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                 stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Score</span>
                            <span class="title-font font-medium text-lg">{{$quizPecentage}}%</span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            @if($quizPecentage >= 70)
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                 stroke-width="3" class="text-green-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-green-700">Status: PASSED ✓</span>
                            @else
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                 stroke-width="3" class="text-red-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-red-700">Status: FAILED ✗</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mx-auto min-w-full p-2 md:flex m-2 justify-between gap-4 mt-6">
                    <a href="{{route('filament.member.pages.quiz-detail-page', ['record' => $currentquizHeader->id])}}" 
                       class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg text-center">
                        View Test Details
                    </a>
                    <a href="{{route('filament.member.resources.my-quizzes.index')}}" 
                       class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg text-center">
                        Back to Quiz History
                    </a>
                    <a href="{{route('filament.member.pages.school-test')}}" 
                       class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg text-center">
                        Take Another Test
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
