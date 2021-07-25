<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Section Home') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-1 px-4 py-5 md:px-8 w-full">
        <div class="w-full mx-auto divide-y md:max-w-6xl">
            <div class="bg-gray-100">
                <div class="flex items-center justify-between mt-4 mb-2">
                    <a href="{{route('createSection')}}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Create a Section</a>
                    @if(Session::has('message'))
                    <h1 class="text-xs font-bold card bg-green-400 p-2 md:px-10 rounded-md text-green-50">
                        {{session::get('message')}}
                    </h1>
                    @endif
                </div>
                <!-- --------------------- START NEW TABLE --------------------->

                <div>
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-green-500 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                                Published
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="capitalize bg-white divide-y divide-gray-200">
                                        @foreach($sections as $section)
                                        <tr>
                                            <td class="px-6 ">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a class="text-blue-400 hover:underline" href="{{ route('detailSection', $section->id) }}">
                                                                {{ $section->name}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm justify-center font-bold text-gray-600">{{ $section->is_active === '1'  ? 'Yes' : 'No' }}</div>
                                            </td>
                                            <td class="sm:flex align-middle justify-center items-center px-6 py-4 text-right text-sm font-medium">
                                                <a href="{{ route('createQuestion', $section->id )}}" class="text-green-300 hover:text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 " viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('editSection', $section->id )}}" class="text-green-300 hover:text-blue-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('editSection', $section->id )}}" class="text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $sections->links() }}
                        </div>
                    </div>
                </div>
                <!-- ---------------- END NEW TABLE --------------------- -->
            </div>
        </div>
    </div>
</x-app-layout>