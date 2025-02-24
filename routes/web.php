<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;

// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Accueil
Route::get('/', function () {
    return view('welcome'); 
})->name('home');

// Dashboard
Route::get('/account/dashboard', function () {
    return view('account/dashboard');
})->middleware('auth')->name('dashboard');

// Profil utilisateur
Route::get('/account/profile', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile');

// Gestion des utilisateurs (Étudiants & Pilotes)
Route::middleware('auth')->group(function () {
    Route::get('/account/students', [UserManagementController::class, 'show'])->name('students_list');
    Route::get('/account/pilots', [UserManagementController::class, 'show'])->name('pilots_list');
    Route::get('/account/{role}/register', [UserManagementController::class, 'showUserRegister'])->name('user_register');
    Route::post('/account/users/register', [UserManagementController::class, 'userRegister'])->name('userRegister');
});
