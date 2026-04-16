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

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/sign-out', [AuthController::class, 'logout'])->name('logout');

    Route::post('/contacts/import', [ContactsController::class, 'importCsv'])->name('contacts.import');
    Route::get('/contacts/export', [ContactsController::class, 'exportCsv'])->name('contacts.export');
    Route::patch('/contacts/{contact}/favorite', [ContactsController::class, 'toggleFavorite'])->name('contacts.favorite');
    Route::post('/contacts/{contact}/interactions', [ContactsController::class, 'storeInteraction'])->name('contacts.interactions.store');
    Route::post('/contacts/{contactId}/restore', [ContactsController::class, 'restore'])->name('contacts.restore');
    Route::resource('contacts', ContactsController::class)->except(['show']);
});
