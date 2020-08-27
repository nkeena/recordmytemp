<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->name('home')->middleware('guest');

Route::view('/use-of-data', 'data-use')->name('data-use');

Route::layout('layouts.auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::livewire('login', 'auth.login')
            ->name('login');

        Route::livewire('register', 'auth.register')
            ->name('register');
    });

    Route::livewire('password/reset', 'auth.passwords.email')
        ->name('password.request');

    Route::livewire('password/reset/{token}', 'auth.passwords.reset')
        ->name('password.reset');

    Route::middleware('auth')->group(function () {
        Route::livewire('email/verify', 'auth.verify')
            ->middleware('throttle:6,1')
            ->name('verification.notice');

        Route::livewire('password/confirm', 'auth.passwords.confirm')
            ->name('password.confirm');

        Route::livewire('profile', 'profile')->name('profile');

        Route::livewire('temperatures', 'temperatures.index')
            ->name('temperatures.index')
            ->middleware('check.log');

        Route::post('temperatures/download', 'DownloadTemperaturesController')
            ->name('temperatures.download')
            ->middleware('check.log');

        Route::livewire('temperatures/record', 'temperatures.record')
            ->name('temperatures.record')
            ->middleware('check.log');

        Route::livewire('logs', 'logs.index')
            ->name('logs.index');

        Route::livewire('logs/create', 'logs.create')
            ->name('logs.create');

        Route::livewire('logs/{log}/edit', 'logs.edit')
            ->name('logs.edit');

        Route::livewire('logs/join', 'logs.join')
            ->name('logs.join');

        Route::livewire('people', 'people.index')
            ->name('people.index')
            ->middleware('check.log');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', 'Auth\LogoutController')
        ->name('logout');
});
