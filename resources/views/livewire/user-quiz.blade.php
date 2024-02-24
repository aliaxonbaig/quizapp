<div>
    {{-- quizSetupInProgress form Starts here --}}

    @if($quizSetupInProgress)
    <div class="grid grid-cols-1 gap-4 2xl:grid-cols-2 lg:gap-8">
        <div class="rounded-lg">
            <form wire:submit.prevent="initializeQuiz">
                {{ $this->preQuizForm }}
                <x-filament-actions::modals />
            </form>
    </div>
        <div class="rounded-lg">
            <section class="text-gray-600 mx-auto body-font">
                <div class="container mx-auto">
                    <div class="flex flex-wrap -m-4 py-2 border-primary-500 border-gray-100">
                        <div class="p-4 w-full">
                            <div class="h-full p-8 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">
                                    <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                                </svg>
                                <p class="leading-relaxed mb-6">{{$quote?->quote}}</p>
                                <a class="inline-flex items-center">
                                    <span class="flex-grow flex flex-col">
                                        <span class="title-font font-medium text-gray-900">Author</span>
                                        <span class="inline-block h-1 w-18 rounded bg-indigo-500 mt-2 mb-1"></span>
                                        <span class="text-gray-500 text-sm">{{$quote?->author}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div>

      <div class="flex min-h-auto p-5 gap-5 items-center justify-center">
        <div class="group h-96 w-80 [perspective:1000px]">
          <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)]">
            <div class="absolute inset-0">
              <img class="h-full w-full rounded-xl object-cover shadow-xl shadow-black/40" src="https://images.unsplash.com/photo-1562583489-bf23ec64651d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80')" alt="" />
            </div>
            <div class="absolute inset-0 h-full w-full rounded-xl bg-black/80 px-12 text-center text-slate-200 [transform:rotateY(180deg)] [backface-visibility:hidden]">
              <div class="flex min-h-full flex-col items-center justify-center">
                <h1 class="text-3xl font-bold">{{$quote?->author}}</h1>
                <p class="text-3xl">"</p>
                <p class="text-base">{{$quote?->quote}}</p>
                <button class="mt-2 rounded-md bg-neutral-800 py-1 px-2 text-sm hover:bg-neutral-900">Read More</button>
              </div>
            </div>
          </div>
        </div>
        <div class="group h-96 w-80 [perspective:1000px]">
            <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)]">
              <div class="absolute inset-0">
                <div class="flex min-h-full flex-col p-5 items-center justify-center">
                    <h1 class="text-3xl font-bold">Author</h1>
                    <p class="text-lg">{{$quote?->author}}</p>
                    <p class="text-base"></p>
                  </div>
                 </div>
              <div class="absolute inset-0 h-full w-full rounded-xl bg-black/90 px-12 text-center text-slate-50 [transform:rotateY(180deg)] [backface-visibility:hidden]">
                <div class="flex min-h-full flex-col items-center justify-center">
                  <p class="text-base">{{$quote?->quote}}</p>
                  <button class="mt-2 rounded-md bg-neutral-800 py-1 px-2 text-sm hover:bg-neutral-900">Read More</button>
                </div>
              </div>
            </div>
          </div>
      </div>
    @endif
    {{-- quizSetupInProgress form Ends here --}}

    {{-- quizInProgress form Starts here --}}
    @if($quizInProgress)

    <div class="px-4 -py-3 sm:px-6 ">
        <div class="flex max-w-auto justify-between p-10">
            <h1 class="text-sm leading-6 font-medium text-gray-900">
                <span class="text-gray-400 font-extrabold p-1">Quiz User</span>
                <span class="font-bold p-1 leading-loose bg-blue-500 text-white rounded-lg">{{Auth::user()->name}}</span>
            </h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                <span class="text-gray-400 font-extrabold p-1">Quiz Progress </span>
                <span class="font-bold p-3 leading-loose bg-blue-500 text-white rounded-full">{{$quizQuestionCounter .'/'. $currentQuizSize}}</span>
            </p>
        </div>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 mb-2 font-medium text-gray-900">
                <span class="mr-2 font-extrabold"> {{$quizQuestionCounter}}</span> {!! nl2br(e($currentQuestion->question))  !!}
                @if($learningMode)
                <x-explanation>
                    {!! nl2br(e($currentQuestion->explanation)) !!}
                </x-explanation>
                @endif
            </h3>
            @if($currentQuestion->getMedia('questions')->first())
            <x-displayImage>
                <img alt="Section Image" src="{{ $currentQuestion->getMedia('questions')->first()->getUrl() }}"
                class="h-full w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />
            </x-displayImage>
            @endif
        </div>

        <div class="p-10">
            <form wire:submit.prevent="startQuiz">
                {{ $this->quizForm }}
                <div class="mt-10">
                <x-filament::button
                type="submit"
                size="lg"
                >
                Next Question
            </x-filament::button>
                </div>
        </form>
        <x-filament-actions::modals />
        </div>
    </div>

    @endif
    {{-- quizInProgress form Ends here --}}

    {{-- quizHasEnded form Starts here --}}
    @if($quizHasEnded)

    <section class="text-gray-600 body-font">
        <div class="bg-white border-2 border-gray-300 shadow overflow-hidden sm:rounded-lg">
            <div class="container px-5 py-5 mx-auto">
                <div class="text-center mb-5 justify-center">
                    <h1 class=" sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">Quiz Result</h1>
                    <p class="text-md mt-10"> Dear <span class="font-extrabold text-blue-600 mr-2"> {{Auth::user()->name.'!'}} </span> You have secured <a class="bg-green-300 px-2 mx-2 hover:green-400 rounded-lg underline" href="{{route('filament.member.pages.quiz-detail-page', ['record' => $currentquizHeader->id])}}">Show quiz details</a></p>
                    <div>
                        <span id="ProgressLabel" class="sr-only">Loading</span>

                        <span
                          role="progressbar"
                          aria-labelledby="ProgressLabel"
                          aria-valuenow="{{$quizPecentage}}"
                          class="block rounded-full bg-gray-200"
                        >
                          <span
                            class="block h-4 rounded-full bg-indigo-600 text-center text-[10px]/4"
                            style="width: {{$quizPecentage}}%"
                          >
                            <span class="rounded-sm bg-white px-0.5 font-bold text-indigo-600">
                                {{$quizPecentage}}%
                            </span>
                          </span>
                        </span>
                      </div>
                </div>
                <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill=" none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Correct Answers</span><span class="title-font font-medium">{{$currectQuizAnswers}}</span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Total Questions</span><span class="title-font font-medium">{{$totalQuizQuestions}}</span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Percentage Scored</span><span class="title-font font-medium">{{$quizPecentage.'%'}}</span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="title-font font-medium mr-5 text-purple-700">Quiz Status</span><span class="title-font font-medium">{{ $quizPecentage > 70 ? 'Pass' : 'Fail' }}</span>
                        </div>
                    </div>
                </div>
                <div class="mx-auto min-w-full p-2 md:flex m-2 justify-between">
                    <a href="{{route('filament.member.pages.quiz-detail-page', ['record' => $currentquizHeader->id])}}" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">See Quizzes Details</a>
                    <a href="{{route('filament.member.resources.my-quizzes.index')}}" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">See All Your Quizzes</a>
                </div>
            </div>
        </div>
    </section>

    @endif
    {{-- quizHasEnded form Ends here --}}

    </div>
