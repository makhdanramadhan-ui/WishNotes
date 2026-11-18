<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WishNoteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1')->name('login.store');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,1')->name('register.store');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [WishNoteController::class, 'index'])->name('dashboard');
    Route::post('/boards', [WishNoteController::class, 'store'])->name('boards.store');
    Route::delete('/boards/{board}', [WishNoteController::class, 'destroy'])->name('boards.destroy');
    Route::post('/logout', [LogoutController::class, 'index'])->name('logout');
});
Route::get('/boards/{board}', [WishNoteController::class, 'show'])->name('boards.show');
Route::post('/boards/{board}/messages', [WishNoteController::class, 'message'])->middleware('throttle:15,1')->name('messages.store');
