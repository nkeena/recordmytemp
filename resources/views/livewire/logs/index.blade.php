@section('title', 'Logs')

<div class="w-full">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 sm:text-5xl text-3xl font-extrabold text-center text-blue-900 leading-9">
            Logs
        </h2>
        <p class="mt-8 sm:px-0 px-4 text-sm text-center text-gray-600 leading-5 sm:flex items-center justify-between sm:space-x-4 sm:space-y-0 space-y-4">

            <a href="{{ route('logs.join') }}" class="flex justify-center sm:w-1/2 w-full px-4 py-2 text-sm font-medium text-white bg-pink-600 border-b-4 border-pink-700 rounded-md hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:shadow-outline-pink active:bg-pink-700 transition duration-150 ease-in-out">
                Join existing
            </a>
            <a href="{{ route('logs.create') }}" class="flex justify-center sm:w-1/2 w-full px-4 py-2 text-sm font-medium text-pink-600 bg-white border-b-4 border border-blue-100 rounded-md hover:text-pink-400 focus:outline-none focus:border-blue-100 focus:shadow-outline-blue active:bg-white transition duration-150 ease-in-out">
                Create new
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="mt-4 bg-white sm:border-b-4 sm:border-blue-100 sm:border-r-2 sm:rounded-lg">
            <div class="px-4 py-4 sm:px-6 w-full flex items-center justify-between sm:rounded-t-lg bg-blue-900 sm:text-base text-sm">
                <div class="text-white sm:font-bold">
                    My logs
                </div>
            </div>
            @if($logs->count())
            <ul x-data="{}">
                @foreach($logs as $log)
                <li @unless($loop->first) class="border-t border-gray-200" @endunless>
                    <div class="flex items-center justify-between px-4 py-4 sm:px-6">
                        <div class="text-sm font-medium text-gray-500 flex items-center space-x-3">
                            @if ($log->id === auth()->user()->current_log_id)
                                <span class="text-green-500">&checkmark;</span>
                            @endif
                            <a wire:click="selectLog({{ $log->id }})" type="button" class="hover:underline cursor-pointer">
                                {{ $log->title }}
                            </a>
                        </div>
                        @if($log->user_id === auth()->id())
                        <div class="text-sm font-medium text-gray-500 space-x-2">
                            <a href="{{ route('logs.edit', $log) }}" class="text-blue-500 underline hover:text-blue-400">edit</a>
                            <a role="button" @click.prevent="if(confirm('Are you sure? You can\'t undo this action!')) { window.livewire.emit('deleteLog', {{ $log->id }}) }" class="text-blue-500 underline hover:text-blue-400">delete</a>
                        </div>
                        @else
                        <div class="text-sm font-medium text-gray-500">
                            <a role="button" @click.prevent="if(confirm('Are you sure?')) { window.livewire.emit('removeLog', {{ $log->id }}) }" class="text-blue-500 underline hover:text-blue-400">remove</a>
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="px-4 py-4 sm:px-6 text-center text-lg">
                You don't have any logs
            </div>
            @endif
        </div>
    </div>
</div>