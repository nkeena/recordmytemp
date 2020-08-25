@section('title', 'Record your temperature')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 sm:text-5xl text-3xl font-extrabold text-center text-blue-900 leading-9">
            New temperature
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white border-b-4 border-blue-100 border-r-2 sm:rounded-lg sm:px-10">
            <form x-data="{ temperature: 0, scale: 'F' }">
                <div>
                    @if ($recorded)
                    <div class="rounded-md bg-green-50 p-4 mb-2">
                        <div class="flex">
                          <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                          </div>
                          <div class="ml-3">
                            <p class="text-sm leading-5 font-medium text-green-800">
                              Successfully recorded
                            </p>
                          </div>
                          <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                              <button wire:click="$set('recorded', false)" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:bg-green-100 transition ease-in-out duration-150">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>                      
                    @endif

                    <label for="email" class="block text-sm font-medium text-gray-700 leading-5">
                        My current temperature
                    </label>

                    <div class="mt-1 rounded-md relative">
                        <input wire:model="temperature" x-model="temperature" id="temperature" name="temperature" placeholder="{{ $placeholderTemp }}" maxlength="5" required autofocus class="text-5xl text-pink-600 sm:text-center font-extrabold appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-200 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:leading-5 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <select wire:model="scale" x-model="scale" aria-label="Currency" class="text-3xl text-blue-600 font-extrabold form-select h-full py-0 pl-2 pr-16 border-transparent bg-transparent">
                              <option value="F"><sup>&#176;</sup>F</option>
                              {{-- <option value="C"><sup>&#176;</sup>C</option> --}}
                            </select>
                        </div>
                    </div>

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button @click.prevent="if(confirm('Are you sure you want to record the temperature ' + temperature + '&deg;' + scale + '?')) { window.livewire.emit('record') }" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-pink-600 border-b-4 border-pink-700 rounded-md hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:shadow-outline-pink active:bg-pink-700 transition duration-150 ease-in-out">
                          Record Temperature
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <p class="mt-4 text-sm text-center text-gray-600 leading-5 max-w">
          <a href="{{ route('temperatures.index') }}" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
            &leftarrow; View past temperatures
          </a>
        </p>
    </div>
</div>