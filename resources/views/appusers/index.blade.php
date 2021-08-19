<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Home') }}
        </h2>
    </x-slot>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-5 mx-auto">
            <div class="flex flex-wrap -m-4 text-center">
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full ">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h2 class="title-font font-medium text-xl text-gray-900">{{$sections->count()}}</h2>
                        <p class="leading-relaxed">Sections</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full ">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                        </svg>
                        <h2 class="title-font font-medium text-xl text-gray-900">{{$activeUsers}}</h2>
                        <p class="leading-relaxed">Users</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full ">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path>
                        </svg>
                        <h2 class="title-font font-medium text-xl text-gray-900">{{$questionsCount}}</h2>
                        <p class="leading-relaxed">Questions</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <h2 class="title-font font-medium text-xl text-gray-900">{{$quizesTaken}}</h2>
                        <p class="leading-relaxed">Quizzes Taken</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="text-gray-600 body-font ">
        <div class="container px-5 py-4 mx-auto flex flex-wrap items-center">
            <div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0 bg-white p-20 rounded-lg">
                <p class="leading-relaxed mt-4">Welcome <span class="font-extrabold text-blue-600 mr-2"> {{Auth::user()->name.'!'}} </span> As a registered user, you can access all resources on our website. Thankyou!</p>
            </div>
            <div class="lg:w-2/6 md:w-1/2 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 bg-white">
                <form action="{{route('startQuiz')}}" method="post">
                    @csrf
                    <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Take a Quiz</h2>
                    <div class="relative mx-full mb-4">
                        <select name="section" class="block w-full mt-1 rounded-md bg-gray-100 border-2 border-gray-500 focus:bg-white focus:ring-0">
                            @if($sections->isEmpty())
                            <option value="">No Quiz Sections Available Yet</option>
                            @else
                            @foreach($sections as $section)
                            @if($section->questions_count>0)
                            <option value="{{$section->id}}">{{$section->name}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="relative mb-4">
                        <select name="quizSize" class="max-w-full block w-full mt-1 rounded-md bg-gray-100 border-2 border-gray-500 focus:bg-white focus:ring-0">
                            @for ($i = 1; $i <= 50; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
                        </select>
                    </div>
                    <button class="block w-full  text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Start Quiz</button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>