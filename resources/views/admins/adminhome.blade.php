<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Home') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">
            <div class="text-center">
                <h2 class="text-2xl tracking-tight leading-10 font-extrabold text-gray-900 md:text-3xl sm:leading-none">
                    QuizApp<span class="text-indigo-600 ml-2">Admin Home</span>
                </h2>
                <p class="text-md mt-10"> Welcome <span class="font-extrabold text-blue-600 mr-2"> {{Auth::user()->name.'!'}} </span> Thank you for loggin in, we can make this website awesome with your support!.</p>
            </div>
            <div class="md:grid grid-cols-3 mt-10 justify-center gap-5">
                <div class="m-3  min-w-full mx-auto">
                    <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold text-blue-800 pr-2">{{$sectionCount}}</span><span> Sections</span>
                    </p>
                </div>
                <div class="m-3  min-w-full mx-auto">
                    <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold text-blue-800 pr-2">{{$questionCount}}</span><span> Total Questions</span>
                    </p>
                </div>
                <div class="m-3  min-w-full mx-auto justify-center">
                    <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold text-blue-800 pr-2">{{$userCount}}</span><span> Active Users</span>
                    </p>
                </div>
            </div>
            <div class="md:grid grid-cols-3 mt-10 justify-center text-center gap-5">
                <div class="m-3 min-w-full mx-auto ">
                    <a href="{{route('listSection')}}">
                        <p class="align-center justify-center tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">
                            View Sections
                        </p>
                    </a>
                </div>
                <div class="m-3 min-w-full mx-auto">
                    <a href="{{route('listSection')}}">
                        <p class="tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">
                            View Users
                        </p>
                    </a>
                </div>
                <div class="m-3 min-w-full mx-auto">
                    <a href="{{route('users.index')}}">
                        <p class="tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">
                            View Latest Users
                </div>
                </p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>