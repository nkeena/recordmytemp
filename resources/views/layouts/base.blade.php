<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <meta name="description" content="A free online temperature tracker to help keep your space safe. Works on any device. We'll even notify you of high temperatures or missed recordings." />
		
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">
        <link rel="icon" href="{{ url(asset('favicon-16x16.png')) }}" sizes="16x16" />
        <link rel="icon" href="{{ url(asset('favicon-32x32.png')) }}" sizes="32x32" />
        <link rel="icon" href="{{ url(asset('android-chrome-192x192.png')) }}" sizes="192x192" />
        <link rel="icon" href="{{ url(asset('android-chrome-512x512')) }}" sizes="512x512" />
        <link rel="apple-touch-icon" href="{{ url(asset('apple-touch-icon.png')) }}" />
        <meta name="msapplication-TileImage" content="{{ url(asset('android-chrome-512x512')) }}" />

        <!-- Twitter and Open Graph tags -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@neilkeena">
        <meta name="twitter:creator" content="@neilkeena">
        <meta property="og:url" content="https://recordmytemp.com" />
        <meta property="og:title" content="Free Temperature Tracker" />
        <meta property="og:description" content="A free online temperature tracker to help keep your space safe. Works on any device. We'll even notify you of high temperatures or missed recordings." />
        <meta property="og:image" content="{{ url(asset('android-chrome-512x512')) }}"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family =Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="bg-blue-50">
        <div class="pt-6 flex flex-col">
            <div class="w-full">
                @include('_nav')
            </div>
            
            <main class="flex-1">
                @yield('content')
            </main>
        
        
            <footer class="py-12 text-xs text-blue-800 text-center leading-5">
                @auth
                    Current log: <a href="{{ route('logs.index') }}" class="text-blue-600 hover:text-blue-500">
                        {{ optional(auth()->user()->currentLog)->title }}
                    </a>
                    <br />
                    @if(auth()->user()->isOwner)
                    Invite code: <a class="text-blue-600">{{ auth()->user()->currentLog->join_code }}</a>
                    @endif
                    <br />
                    <br />
                @endauth
                &copy; {{ date('Y') }} Neil Keena. All Rights Reserved.
            </footer>
        
        </div>

        <script src="{{ url(mix('js/app.js')) }}"></script>
        @livewireScripts


        <script>
            window.addEventListener('person-removed', event => {
                alert(event.detail.person + ' was removed');
            })

            window.addEventListener('log-deleted', event => {
                alert('The log: ' + event.detail.log + ' was deleted');
            })

            window.addEventListener('log-removed', event => {
                alert('The log: ' + event.detail.log + ' was removed');
            })
        </script>
    
    </body>
</html>
