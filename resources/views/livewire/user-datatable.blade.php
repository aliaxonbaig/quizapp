<div>
    <x-slot name="header">
        <div class="md:flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Section Home') }}
            </h2>
            @if(session()->has('success'))
            <span>
                <h1 class="text-medium font-bold rounded-xl bg-green-400 px-2 text-white">
                    {{session('success')}}
                </h1>
                @elseif(session()->has('warning'))
                <h1 class="text-medium font-bold rounded-xl bg-red-400 px-2 text-white">
                    {{session('warning')}}
                </h1>
            </span>
            @endif
        </div>
    </x-slot>
    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="w-full flex">
            <div class="w-3/6 mx-1">
                <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Search users...">
            </div>
            <div class="w-1/6 relative mx-1">
                <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="created_at">Sign Up Date</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                </div>
            </div>
            <div class="w-1/6 relative mx-1">
                <select wire:model="orderAsc" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="1">Ascending</option>
                    <option value="0">Descending</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                </div>
            </div>
            <div class="w-1/6 relative mx-1">
                <select wire:model="perPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                </div>
            </div>
        </div>
        <div class="mx-auto">
            <div class="flex justify-between items-center py-4">
                <a href="{{route('createSection')}}" class="tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">Create a Section</a>
                <a href="{{route('adminhome')}}" class="tracking-wide font-bold rounded border-2 border-blue-500 hover:border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition shadow-md py-2 px-6 items-center">Back</a>
            </div>
            <div class="bg-white border-2 border-gray-300 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <dl>
                        <div class="bg-white sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                            <dd class=" mt-1 font-extrabold text-gray-900 sm:mt-0 sm:col-span-1">
                                User Name
                            </dd>
                            <dd class="mt-1 font-extrabold text-gray-900 sm:mt-0 sm:col-span-1">
                                Email Address
                            </dd>
                            <dd class="mt-1 font-extrabold text-gray-900 sm:mt-0 sm:col-span-1">
                                Roles
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="border-t border-gray-300">
                    <dl>
                        @foreach($users as $user)
                        <div class="bg-gray-50 px-4 py-1 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 hover:bg-green-100 border-b-2 border-gray-200">
                            <dt class=" text-sm font-medium text-gray-700">
                                {{ $user->name}}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                <p class="mt-1 max-w-2xl text-sm text-gray-700">
                                    {{ $user->email  }}
                                </p>
                            </dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                @foreach($user->roles as $role)
                                <span class="bg-green-200 px-1 font-bold text-gray-600 rounded-lg">{{$role->name}}</span>
                                @endforeach
                            </dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                <div class="flex justify-end items-center">
                                    <a href="#" class="text-green-500 hover:text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-500 hover:text-blue-700 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="# " class="text-green-500 hover:text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    @can('manage admins')
                                    <a class="text-red-500 hover:text-red-700">
                                        <button type="submit" wire:click="deleteUser({{ $user->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 pt-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </a>
                                    @endcan
                                </div>
                            </dd>
                        </div>
                        @endforeach
                    </dl>
                </div>
            </div>
            {{$users->links()}}
        </div>
    </div>
</div>