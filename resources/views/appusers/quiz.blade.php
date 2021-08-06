<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AppUser Home') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <!-- Pass the variables and load Livewire component -->
        @livewire('user-quizlv', ['sectionId' => $sectionId,'quizSize' => $quizSize])
    </div>
</x-app-layout>