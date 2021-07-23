<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Section Home') }}
        </h2>
    </x-slot>
    <div class="antialiased text-gray-900 px-6">
        <div class="mx-auto py-5 divide-y md:max-w-4xl">
            <div class="mx-auto bg-gray-100">
                <div class="flex items-center mt-4">
                    <a href="{{route('createSection')}}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Create a Section</a>
                </div>
                <!-- --------------------- START NEW TABLE --------------------->

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
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
                                                <div class="text-sm text-gray-900">{{ $section->is_active === '1'  ? 'Active' : 'Not Active' }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <a href="{{ route('createQuestion', $section->id )}}" class="text-indigo-600 hover:text-indigo-900">Add Question</a>
                                                <a href="{{ route('editSection', $section->id )}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>

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
    </div>
</x-app-layout>