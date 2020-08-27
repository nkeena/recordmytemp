@extends('layouts.app')

@section('title', 'Free Temperature Tracker')

@section('content')
<div class="bg-blue-50 relative">
    <div class="hidden sm:block sm:absolute sm:inset-0">
      <svg class="absolute bottom-0 right-0 transform translate-x-1/2 mb-48 text-blue-200 lg:top-0 lg:mt-28 lg:mb-0 xl:transform-none xl:translate-x-0" width="364" height="384" viewBox="0 0 364 384" fill="none">
        <defs>
          <pattern id="eab71dd9-9d7a-47bd-8044-256344ee00d0" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
            <rect x="0" y="0" width="4" height="4" fill="currentColor" />
          </pattern>
        </defs>
        <rect width="364" height="384" fill="url(#eab71dd9-9d7a-47bd-8044-256344ee00d0)" />
      </svg>
    </div>
    <div class="relative">
      <div class="mt-8 sm:mt-16 md:mt-20 lg:mt-24">
        <div class="mx-auto max-w-screen-xl">
          <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="px-4 sm:px-6 sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:flex lg:items-center">
              <div>
                <a href="https://www.cdc.gov/coronavirus/2019-ncov/symptoms-testing/symptoms.html" target="_blank" rel="noreferrer" class="inline-flex items-center text-blue-800 bg-blue-200 rounded-full p-1 pr-2 sm:text-base lg:text-sm xl:text-base hover:text-blue-900">
                  <span class="px-3 py-0.5 text-white text-xs font-semibold leading-5 uppercase tracking-wide bg-pink-600 rounded-full">COVID-19</span>
                  <span class="ml-4 text-sm leading-5">Symptoms to watch for</span>
                  <svg class="ml-2 w-5 h-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </a>
                <h2 class="mt-4 text-4xl tracking-tight leading-10 font-extrabold text-blue-900 sm:mt-5 sm:leading-none sm:text-6xl lg:mt-6 lg:text-5xl xl:text-6xl">
                  Easily track
                  <br class="hidden md:inline">
                  <span class="text-pink-600">temperatures</span>
                </h2>
                <p class="mt-3 text-base text-blue-800 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                 <strong class="font-bold">Keep your space safe</strong> by using this <strong class="uppercase font-bol">free</strong> online tool to track temperatures. We'll email you when someone doesn't check in or if someone's temperature is above normal.
                </p>
                <div class="mt-5 sm:flex lg:justify-start justify-center md:mt-8">
                  <div class="rounded-md">
                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border-b-4 border-pink-700 text-base leading-6 font-medium rounded-md text-white bg-pink-600 hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:shadow-outline-pink transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                      Get started
                    </a>
                  </div>
                  <div class="mt-3 rounded-md sm:mt-0 sm:ml-3">
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 text-blue-600  hover:text-blue-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                      Sign in
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6 text-xl">
              <img class="md:w-auto w-full max-w-md mx-auto" src="/images/temperatures.png" alt="temperature tracker app screenshot" />
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
