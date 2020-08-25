@section('title', 'Create a new log')

<div class="w-full">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-3xl font-extrabold text-center text-blue-900 leading-9">
            Edit log
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
            <form wire:submit.prevent="edit">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 leading-5">
                        Title
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="title" id="title" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>

                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="dailyCount" class="block text-sm font-medium text-gray-700 leading-5">
                        Expected daily records
                    </label>

                    <div class="mt-1 rounded-md shadow-sm w-32">
                        <input wire:model.lazy="dailyCount" id="dailyCount" type="number" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('dailyCount') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>

                    <p class="mt-2 text-sm text-gray-600">This is the total number of temperature recordings expected per person.</p>

                    @error('dailyCount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="maxTemp" class="block text-sm font-medium text-gray-700 leading-5">
                        Normal limit
                    </label>

                    <div class="mt-1 rounded-md shadow-sm w-32">
                        <input wire:model.lazy="maxTemp" id="maxTemp" maxlength="5" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('maxTemp') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>

                    <p class="mt-2 text-sm text-gray-600">If this temperature is exceeded, it will be considered a fever.</p>

                    @error('maxTemp')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <fieldset class="mt-6">
                    <legend class="text-base leading-6 font-medium text-gray-900">Notifications</legend>
                    <div class="mt-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input wire:model="notifyMaxTemp" id="notifyMaxTemp" type="checkbox" class="form-checkbox h-4 w-4 text-blue-500 transition duration-150 ease-in-out">
                            </div>
                            <div class="ml-3 text-sm leading-5">
                                <label for="notifyMaxTemp" class="font-medium text-gray-700">Temperature alerts</label>
                                <p class="text-gray-500">Notify me if someone's temperature exceeds the normal limit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input wire:model="notifyDailyCount" id="notifyDailyCount" type="checkbox" class="form-checkbox h-4 w-4 text-blue-500 transition duration-150 ease-in-out">
                            </div>
                            <div class="ml-3 text-sm leading-5">
                                <label for="notifyDailyCount" class="font-medium text-gray-700">Missing records</label>
                                <p class="text-gray-500">Notify me if someone misses a daily recording.</p>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="mt-6">
                    <label for="dailyCountAt" class="block text-sm font-medium text-gray-700 leading-5">
                        Notify me of missing records after:
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <select wire:model="dailyCountAt" id="dailyCountAt" class="form-select appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('dailycountAt') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                            <option value="00:00:00">0:00 am</option>
                            <option value="01:00:00">1:00 am</option>
                            <option value="02:00:00">2:00 am</option>
                            <option value="03:00:00">3:00 am</option>
                            <option value="04:00:00">4:00 am</option>
                            <option value="05:00:00">5:00 am</option>
                            <option value="06:00:00">6:00 am</option>
                            <option value="07:00:00">7:00 am</option>
                            <option value="08:00:00">8:00 am</option>
                            <option value="09:00:00">9:00 am</option>
                            <option value="10:00:00">10:00 am</option>
                            <option value="11:00:00">11:00 am</option>
                            <option value="12:00:00">12:00 pm</option>
                            <option value="13:00:00">1:00 pm</option>
                            <option value="14:00:00">2:00 pm</option>
                            <option value="15:00:00">3:00 pm</option>
                            <option value="16:00:00">4:00 pm</option>
                            <option value="17:00:00">5:00 pm</option>
                            <option value="18:00:00">6:00 pm</option>
                            <option value="19:00:00">7:00 pm</option>
                            <option value="20:00:00">8:00 pm</option>
                            <option value="21:00:00">9:00 pm</option>
                            <option value="22:00:00">10:00 pm</option>
                            <option value="23:00:00">11:00 pm</option>
                        </select>
                    </div>

                    @error('dailyCountAt')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-pink-600 border-b-4 border-pink-700 rounded-md hover:bg-pink-500 hover:border-pink-600 focus:outline-none focus:border-pink-700 focus:shadow-outline-pink active:bg-pink-700 transition duration-150 ease-in-out">
                            Save Changes
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>