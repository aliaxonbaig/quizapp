<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AppUser Home') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">
            <div class="text-center">
                <h2 class="text-2xl tracking-tight leading-10 font-extrabold text-gray-900 md:text-3xl sm:leading-none">
                    AppUser<span class="text-indigo-600 ml-2">Home</span>
                </h2>
                <p class="text-md mt-10"> Welcome <span class="font-extrabold text-blue-600 mr-2"> {{Auth::user()->name.'!'}} </span> As a registered user, you can access all resources on our website. Thankyou!</p>
            </div>
            <div class="md:grid grid-cols-3 mt-10 justify-center gap-5">
                <div class="m-3  min-w-full mx-auto">
                    <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold text-blue-800 pr-2">99</span><span> Sections</span>
                    </p>
                </div>
                <div class="m-3  min-w-full mx-auto">
                    <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold text-blue-800 pr-2">100</span><span> Total Questions</span>
                    </p>
                </div>
                <div class="m-3  min-w-full mx-auto justify-center">
                    <p class="bg-white tracking-wide text-gray-800 font-bold rounded border-2 border-blue-500 hover:border-blue-500 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 items-center">
                        <span class="mx-auto font-extrabold text-blue-800 pr-2">200</span><span> Registered Users</span>
                    </p>
                </div>
            </div>
            <div class="md:grid grid-cols-3 mt-10 justify-center text-center gap-5">
                <div class="grid grid-cols-1 gap-6">
                    <form action="{{route('startQuiz')}}" method="post">
                        @csrf
                        <select name="section" class="block w-full mt-1 rounded-md bg-gray-100 border-2 border-gray-500 focus:bg-white focus:ring-0">
                            <option value="-">Select a Section </option>
                            @foreach($sections as $section)
                            <option value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                        </select>
                        <select name="number" class="block w-full mt-1 rounded-md bg-gray-100 border-2 border-gray-500 focus:bg-white focus:ring-0">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                        </select>
                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button type="submit" class="ml-4">
                                {{ __('Start Quiz') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>