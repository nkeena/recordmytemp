@section('title', 'People')

<div class="w-full">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 sm:text-5xl text-3xl font-extrabold text-center text-blue-900 leading-9">
            People
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
          
        <div class="mt-4 bg-white sm:border-b-4 sm:border-blue-100 sm:border-r-2 sm:rounded-lg">
            <div class="px-4 py-4 sm:px-6 w-full text-center sm:rounded-t-lg bg-blue-900 sm:text-base text-sm text-blue-200">
                Invite more people to use this temperature log using the invite code: <code class="bg-blue-200 text-blue-900 px-2 py-1 rounded">{{ auth()->user()->currentLog->join_code }}</code>
            </div>
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
            @if($people->count())
            <ul>
                @foreach($people as $person)
                <li wire:key="{{ $person->id }}" @unless($loop->first) class="border-t border-gray-200" @endunless>
                    <div class="flex items-center justify-between px-4 py-4 sm:px-6">
                        <div class="text-sm font-medium text-gray-500">
                            {{ $person->name }}
                        </div>
                        <div class="text-3xl text-pink-600 font-extrabold">
                            <div class="text-sm font-medium text-gray-500 space-x-3 flex items-center" x-data="{}">
                                @if($person->pivot->notifications)
                                <div class="flex items-center">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="bell text-gray-500 mr-1.5 w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    <a role="button" wire:click="snoozeNotifications({{ $person->id }})" class="flex items-center text-blue-500 underline hover:text-blue-400">
                                        turn off
                                    </a>
                                </div>
                                @else
                                <div class="flex items-center">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="bell text-gray-200 mr-1.5 w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    <a role="button" wire:click="enableNotifications({{ $person->id }})" class="flex items-center text-blue-500 underline hover:text-blue-400">
                                        turn on
                                    </a>
                                </div>
                                @endif
                                <a role="button" @click.prevent="if(confirm('Are you sure?')) { window.livewire.emit('removePerson', {{ $person->id }}) }" class="text-blue-500 underline hover:text-blue-400">remove</a>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="px-4 py-4 sm:px-6 text-center text-lg">
                No people found
            </div>
            @endif
        </div>
    </div>
</div>