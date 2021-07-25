<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Section Detail') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-1 px-4 py-5 md:px-8 w-full">
        <div class="w-full mx-auto divide-y md:max-w-6xl">
            <div class="bg-gray-100">
                <div class="flex justify-between items-center mt-4 mb-2">
                    <a href="{{route('dashboard')}}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Delete Question</a>
                    <a href="{{url()->previous()}}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Back</a>
                </div>
                <!-- --------------------- START NEW TABLE --------------------->

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-green-500 text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                                Item
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                                Details
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Question
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $question->question }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Explanation
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
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
                        <thead class="bg-green-500 text-white">
                            <tr class="max-w-auto">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Answer
                                </th>
                                <th scope="col" class="grid px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Correct Option?
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($answers as $answer)
                            <tr grid grid-cols-4>
                                <td class="px-6 py-4 cols-span-3">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $answer->answer}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 cols-span-1">
                                    <div class="text-sm text-gray-900">{{ $answer->is_checked === '1'  ? 'Correct Option' : 'Wrong Option' }}</div>
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