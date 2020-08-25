@section('title', 'Create a new log')

<div class="w-full">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-3xl font-extrabold text-center text-blue-900 leading-9">
            Join a log
        </h2>

        <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
            &leftarrow;
            <a href="{{ route('logs.index') }}" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                back to my logs
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white border-b-4 border-r-2 border-blue-100 sm:rounded-lg sm:px-10">
            <form wire:submit.prevent="join">

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 leading-5">
                        Enter your invite code:
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="code" id="code" type="text" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('code') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>

                    @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-pink-600 border-b-4 border-pink-700 rounded-md hover:bg-pink-500 hover:border-pink-600 focus:outline-none focus:border-pink-700 focus:shadow-outline-pink active:bg-pink-700 transition duration-150 ease-in-out">
                            Join
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>