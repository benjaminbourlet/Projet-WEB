<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome'); 
})->name('home');

Route::get('/account/dashboard', function () {
    return view('account/dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/account/profile', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile');