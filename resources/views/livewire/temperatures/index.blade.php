@section('title', 'Temperature Log')

<div class="w-full" x-data="{}">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 sm:text-5xl text-3xl font-extrabold text-center text-blue-900 leading-9">
            Temperatures
        </h2>
        <p class="mt-8 sm:px-0 px-4 text-sm text-center text-gray-600 leading-5 sm:flex items-center justify-between sm:space-x-4 sm:space-y-0 space-y-4">

            <a href="{{ route('temperatures.record') }}" class="mx-auto flex items-center justify-center sm:w-1/2 w-full px-4 py-2 text-sm font-medium text-white bg-pink-600 border-b-4 border-pink-700 rounded-md hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:shadow-outline-pink active:bg-pink-700 transition duration-150 ease-in-out">
                <svg fill="none" class="w-4 h-4 mr-1.5" viewBox="0 0 24 24" stroke="currentColor" className="pencil-alt w-6 h-6"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg> Record my temperature
            </a>
            @if(auth()->user()->is_owner)
            <button form="download" type="submit" class="flex items-center justify-center sm:w-1/2 w-full px-4 py-2 text-sm font-medium text-pink-600 bg-white border-b-4 border border-blue-100 rounded-md hover:text-pink-400 focus:outline-none focus:border-blue-100 focus:shadow-outline-blue active:bg-white transition duration-150 ease-in-out">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" className="download w-6 h-6"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> Download
            </button>
            @endif
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
          
        <div class="mt-4 bg-white sm:border-b-4 sm:border-blue-100 sm:border-r-2 sm:rounded-lg">
            <div class="px-4 py-4 sm:px-6 w-full flex items-center justify-between sm:rounded-t-lg bg-blue-900 sm:text-base text-sm">
                <div class="text-white sm:font-bold">
                    {{ $dateFilterSelected }}
                </div>
                <select wire:model="filter" class="inline-block form-select border-none appearance-none bg-blue-900 text-white sm:font-bold hover:bg-blue-800 sm:text-base text-sm">
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="week">This week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
            @if(auth()->user()->is_owner)
            <div class="relative border-b border-blue-100">
                <input wire:model="search" class="pl-4 py-3 block w-full pr-10 sm:text-sm sm:leading-5 rounded-none focus:outline-none" placeholder="search for someone...">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-cursor">
                    @if($search)
                    <button role="button" wire:click.prevent="$set('search', '')">
                        <svg wire:click.prevent="$set('search', '')" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" class="x w-6 h-6">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    @else
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    @endif
                </div>
            </div>
            @endif
            @if($temperatures->count())
            <ul>
                @foreach($temperatures as $temp)
                <li wire:key="{{ $temp->id }}" @unless($loop->first) class="border-t border-gray-200" @endunless>
                    <div class="flex items-center justify-between px-4 py-4 sm:px-6">
                        <div class="text-sm font-medium text-gray-500">
                            @if(auth()->user()->is_owner)
                                <div class="text-base font-bold truncate">{{ $temp->user->name }}</div>
                            @endif
                            @displayDate($temp->created_at, $timestampFormat)
                        </div>
                        <div class="text-3xl text-pink-600 font-extrabold flex items-center">
                            <div>
                            @if($temp->temperature > $temp->log->max_temp)&#129298; @endif
                            {{ $temp->temperature }} <sup class="text-blue-400 text-lg"><sup>&#176;</sup>{{ $temp->scale }}</sup>
                            </div>
                            <button @click.prevent="if(confirm('Are you sure you want to delete the record?')) { window.livewire.emit('deleteTemperature', {{ $temp->id }}) }" class="ml-2 p-2 text-gray-500 hover:text-red-500"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="trash w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="px-4 py-4 sm:px-6 text-center text-lg">
                No temperatures recorded
            </div>
            @endif
        </div>
    </div>

    <form id="download" class="block" method="post" action="{{ route('temperatures.download') }}">
        @csrf
        <input type="hidden" name="filter" value="{{ $filter }}" />
        <input type="hidden" name="search" value="{{ $search }}" />
    </form>
</div>