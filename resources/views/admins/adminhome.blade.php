<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Home') }}
        </h2>
    </x-slot>
    <div class="antialiased text-gray-900 px-6">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            <div class="flex">
                <a href="{{route('listSection')}}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">View Sections</a>
            </div>
        </div>
    </div>
</x-app-layout>