<x-app-layout>
    <x-slot name="header">
        <div class="md:flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Quiz Home') }}
            </h2>

            @if(Session::has('success'))
            <span>
                <h1 class="text-medium font-bold rounded-xl bg-green-400 px-2 text-white">
                    {{session::get('success')}}
                </h1>
                @elseif(Session::has('warning'))
                <h1 class="text-xs font-bold card bg-red-400  px-2 text-gray-500">
                    {{session::get('warning')}}
                </h1>
            </span>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto">
                <div class="flex justify-between items-center py-4">
                    <a href="{{route('appuserIndex')}}"" class=" tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-1 px-6 items-center">Take a New Quiz</a>
                    <p class="tracking-wide font-bold rounded @if(round($quizAverage,2)<70) bg-red-500 @endif  @if(round($quizAverage,2)>=70) bg-green-600 @endif text-white shadow-md py-2 px-6 items-center">Average Score: <span class="mx-2"> {{round($quizAverage,2) .'%'}}</span></p>
                </div>
                <!-- --------------------- START NEW TABLE --------------------->

                <div class=" flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="tracking-wide font-bold rounded border-2 bg-green-500 text-white  transition shadow-md py-2 px-6 items-center">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                                Quiz Size
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                                Score
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="capitalize bg-white divide-y divide-gray-200">
                                        @foreach($userQuizzes as $quiz)
                                        <tr class="hover:bg-green-100">
                                            <td class="px-6 ">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a class="text-white px-6 font-extrabold py-1 rounded-lg bg-blue-500 hover:bg-blue-600 hover:underline" href="{{route('userQuizDetails', $quiz->id)}}">
                                                                {{ $quiz->quiz_size}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-1">
                                                <div class="text-sm text-gray-900">{{ $quiz->completed ? 'Completed' : 'Not Completed' }}</div>
                                            </td>
                                            <td class="px-6 py-1">
                                                <div class="text-sm ">
                                                    <progress class="max-w-full  mx-auto mr-1 " id="quiz-{{$quiz->id}}" value="{{$quiz->score}}" max="100"> {{$quiz->score}} </progress> <span> {{$quiz->score .'%'}}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-1">
                                                <div class="text-sm text-gray-900">{{ $quiz->updated_at->diffForHumans()}}</div>
                                            </td>
                                            <td class="sm:flex align-middle justify-center items-center px-6 py-1 text-right text-sm font-medium">
                                                <a href="{{route('userQuizDetails', $quiz->id)}}" class="text-green-500 hover:text-green-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-500 hover:text-blue-700 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <form action="{{route('deleteUserQuiz', $quiz->id)}}" method="post">
                                                    @csrf
                                                    <a class="text-red-500 hover:text-red-700">
                                                        <button type="submit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 pt-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $userQuizzes->links() }}
                        </div>
                    </div>
                </div>
                <!-- ---------------- END NEW TABLE --------------------- -->
            </div>
        </div>
    </div>
</x-app-layout>