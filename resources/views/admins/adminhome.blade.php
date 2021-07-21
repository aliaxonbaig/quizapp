<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Home') }}
        </h2>
    </x-slot>
    <div class="antialiased text-gray-900 px-6">
        <div class="max-w-xl mx-auto py-5 divide-y md:max-w-4xl">
            <div class="flex items-center mt-4">
                <a href="{{route('createSection')}}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Create a New Section</a>
            </div>
        </div>
    </div>
</x-app-layout>