<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex">
                <div>
                <a
                    href=""
                    rel="noopener noreferrer"
                    target="_blank"
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                  </svg>

                </a>
            </div>
            <div>
                <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                    "{{$randomQuote->quote}}"
                </p>
                <p class="ml-4 text-sm font-bold text-gray-500 dark:text-gray-400 align-content-end">
                    -- {{ $randomQuote->author}}
                </p>
            </div>
            </div>

            <div class="flex flex-col items-end gap-y-1">

            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
