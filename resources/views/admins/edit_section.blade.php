<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('edit Section') }}
        </h2>
    </x-slot>
    <div class="antialiased text-gray-900 px-6">
        <div class="max-w-xl mx-auto py-5 divide-y md:max-w-4xl">
            <div class="mx-auto bg-gray-100">
                <h2 class="text-2xl font-bold card bg-green-600 p-4 text-gray-100 rounded-t-lg mx-auto">New Section</h2>
                @if(Session::has('message'))
                <h1 class="text-xs font-bold card bg-green-400 p-2 -mb-2 text-green-50">
                    {{session::get('message')}}
                </h1>
                @endif
                <div class="mt-2 max-w-auto mx-auto card p-4 bg-white rounded-b-lg shadow-md">
                    <div class="grid grid-cols-1 gap-6">
                        <form action="{{route('updateSection', $section->id)}}" method="post">
                            @csrf
                            <label class="block">
                                <span class="text-gray-700">Section Name</span>
                                @error('name')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <input name="name" value="{{old('name', $section->name)}}" type="text" class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" />
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Section Description</span>
                                @error('description')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <input name="description" value="{{old('description', $section->description)}}" type="text" class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" />
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Is this section active?</span>
                                @error('is_active')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <select name="is_active" value="{{old('is_active', $section->is_active)}}" class="block w-full mt-1 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                                    <option value="1" {{ $section->is_active === '1' ? 'selected' : '' }}>
                                        Yes
                                    </option>
                                    <option value="0" {{ $section->is_active === '0' ? 'selected' : '' }}>
                                        No
                                    </option>
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Section details</span>
                                @error('details')
                                <span class="text-red-700 text-xs content-end float-right">{{$message}}</span>
                                @enderror
                                <textarea name="details" class="mt-1 bg-gray-100 block w-full rounded-md bg-graygray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" rows="3">{{old('details', $section->details)}}</textarea>
                            </label>
                            <div class="flex items-center justify-end mt-4">
                                <a href="{{route('listSection')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Back</a>

                                <x-jet-button type="submit" class="ml-4">
                                    {{ __('Update') }}
                                </x-jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>