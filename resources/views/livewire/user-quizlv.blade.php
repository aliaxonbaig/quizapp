<div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">
    <div class="text-center">
        <h2 class="text-2xl tracking-tight leading-10 font-extrabold text-gray-900 md:text-3xl sm:leading-none">
            AppUser<span class="text-indigo-600 ml-2">Home</span>
        </h2>
        <p class="text-md mt-10"> Welcome <span class="font-extrabold text-blue-600 mr-2"> {{Auth::user()->name.'!'}} </span> As a registered user, you can access all resources on our website. Thankyou!</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <form wire:submit.prevent="nextQuestion">
            @csrf
            <div class="block p-2 m-2 font-extrabold bg-green-200 text-green-400">
                <p">{{$currentQuestion->question}} </p>
            </div>
            <div class="grid grid-cols-1 my-5 justify-center">
                @foreach($currentQuestion->answers as $answer)
                <div class="grid grid-cols-1 my-5 justify-center">
                    <label class="flex items-center">
                        <input id=question-{{$answer->id}} value={{$answer->id .','.$answer->is_checked}} wire:model="userAnswered" type="checkbox">
                        <p p-1 m-1 bg-gray-400 text-gray-700 font-extrabold min-w-full mx-auto px-5> {{$answer->answer}}</p>
                    </label>
                </div>
                @endforeach
            </div>
            <div class="flex items-center justify-end mt-4">
                @if($count < $size-1) <button type="submit" class="ml-4">Next<button>
                        @else
                        <button type="submit" class="ml-4">Show Result<button>
                                @endif
            </div>
        </form>
    </div>
</div>