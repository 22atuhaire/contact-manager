<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('contacts.index');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/sign-up', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/sign-up', [AuthController::class, 'register']);

    Route::get('/sign-in', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/sign-in', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/sign-out', [AuthController::class, 'logout'])->name('logout');
    Route::resource('contacts', ContactsController::class)->except(['show']);
});
