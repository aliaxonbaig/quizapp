<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Section Detail') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto">
                <div class="flex justify-between items-center py-4">
                    <a href="{{route('deleteQuestion',$question->id)}}" class="tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">Delete Question</a>
                    <a href="{{route('listSection')}}" class="tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">Back</a>
                </div>
                <!-- --------------------- START NEW TABLE --------------------->

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="tracking-wide font-bold rounded border-2 bg-green-500 text-white  transition shadow-md py-2 px-6 items-center">
                                        <tr>
                                            <th scope=" col" class="px-6 py-3 text-left text-xs font-extrabold  uppercase tracking-wider">
                                                Item
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-extrabold  uppercase tracking-wider">
                                                Details
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Question
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $question->question }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Explanation
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $question->explanation}}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Status
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $question->is_active === '1'  ? 'Active' : 'Not Active' }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Details
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-lg text-bold">
                                                <div class="text-sm text-gray-900">{{ $question->section->name }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Created By
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-lg text-bold">
                                                <div class="text-sm text-gray-900">{{ $question->user->name}}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ---------------- END NEW TABLE --------------------- -->

                <!-- --------------------- START NEW TABLE --------------------->
                <div class="mt-5 rounded-t-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="tracking-wide font-bold rounded border-2 bg-green-500 text-white  transition shadow-md py-2 px-6 items-center">
                            <tr class="max-w-auto">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Answer
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Choice
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($answers as $answer)
                            <tr class="hover:bg-green-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $answer->answer}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="@if($answer->is_checked === '1') bg-green-400 p-1 text-white rounded-xl @endif justify-center mx-auto text-xs font-extrabold  "> {{ $answer->is_checked === '1'  ? 'Correct' : 'Wrong' }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- -------------------------------end table ------------------------ -->
            </div>
        </div>
    </div>
</x-app-layout>