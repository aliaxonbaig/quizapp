<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Home') }}
        </h2>
    </x-slot>
    <div class="antialiased text-gray-900 px-6">
        <div class="max-w-xl mx-auto py-5 divide-y md:max-w-4xl">
            <div class="mx-auto bg-gray-100">
                <h2 class="text-2xl font-bold card bg-green-600 p-4 text-gray-100 rounded-t-lg mx-auto">New Question</h2>
                @if(Session::has('message'))
                <h1 class="text-xs font-bold card bg-green-400 p-2 -mb-2 text-green-50">
                    {{session::get('message')}}
                </h1>
                @endif
                <div class="mt-2 max-w-auto mx-auto card p-4 bg-white rounded-b-lg shadow-md">
                    <div class="grid grid-cols-1 gap-6">
                        <form action="{{route('storeQuestion', $section)}}" method="post">
                            @csrf
                            <label class="block">
                                <span class="text-gray-700">Question</span>
                                @error('question')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <input name="question" value="{{ old('question') }}" type="text" class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" />
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Explanation</span>
                                @error('explanation')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <textarea name="explanation" value="{{ old('explanation') }}" class="mt-1 bg-gray-100 block w-full rounded-md bg-graygray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" rows="2"></textarea>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Is this question active?</span>
                                @error('is_active')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <select name="is_active" value="{{ old('is_active') }}" class="block w-full mt-1 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </label>
                            <div class="flex justify-center">
                                <div class="flex-col-1">
                                    Hello
                                </div>
                                <div class="flex-col-11">
                                    This will be a question
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <a href="{{route('adminhome')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Back</a>

                                <x-jet-button type="submit" class="ml-4">
                                    {{ __('Create') }}
                                </x-jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>