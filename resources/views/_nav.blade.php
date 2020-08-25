<nav class="z-10 relative max-w-screen-xl mx-auto flex items-center justify-between px-4 sm:px-6">
    <div class="flex items-center flex-1">
      <div class="flex items-center w-full md:w-auto space-x-2">
        <span class="text-2xl">&#129298;</span>
        <span class="text-blue-900 font-bold">RecordMyTemp</span>
      </div>
    </div>
    <div class="md:flex">
      @auth
      <div class="relative inline-block text-left" x-data="{ open: false }">
        <div>
          <button @click.prevent="open = !open" class="flex items-center text-blue-500 hover:text-blue-600 focus:outline-none focus:text-blue-600" aria-label="Options" id="options-menu" aria-haspopup="true" aria-expanded="true">
            Menu 
            <svg class="ml-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
        <div @click.away="open = false" 
             x-cloak
             x-show="open" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg"
        >
          <div class="rounded-md bg-white shadow-xs">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
              <a href="{{ route('temperatures.index') }}" class="block px-4 py-2 text-sm leading-5 text-blue-700 hover:bg-blue-100 hover:text-blue-900 focus:outline-none focus:bg-blue-100 focus:text-blue-900" role="menuitem">Temperatures</a>
              @if(auth()->user()->is_owner)
              <a href="{{ route('people.index') }}" class="block px-4 py-2 text-sm leading-5 text-blue-700 hover:bg-blue-100 hover:text-blue-900 focus:outline-none focus:bg-blue-100 focus:text-blue-900" role="menuitem">People</a>
              @endif
              <a href="{{ route('logs.index') }}" class="block px-4 py-2 text-sm leading-5 text-blue-700 hover:bg-blue-100 hover:text-blue-900 focus:outline-none focus:bg-blue-100 focus:text-blue-900" role="menuitem">Logs</a>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm leading-5 text-blue-700 hover:bg-blue-100 hover:text-blue-900 focus:outline-none focus:bg-blue-100 focus:text-blue-900" role="menuitem">
                  Sign out
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endauth
    </div>
</nav>