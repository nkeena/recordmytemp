@extends('layouts.base')

@section('body')
    <div class="h-full w-full flex flex-col justify-center items-center py-12 bg-blue-50 sm:px-6 lg:px-8 relative">
          
        @yield('content')
    </div>
@endsection
