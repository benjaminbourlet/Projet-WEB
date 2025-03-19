<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfferController;


// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Accueil
Route::get('/', [CompanyController::class, 'companyCarrousel'])->name('home');

// Dashboard
Route::get('/account/dashboard', function () {
    return view('account/dashboard');
})->middleware('auth')->name('dashboard');

// Profil utilisateur
Route::get('/account/profile', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/companies', [CompanyController::class, 'show'])->name(name: 'company_list');
    Route::get('/companies/register', [CompanyController::class, 'showCompanyRegister'])->name('company_register');
    Route::post('/companies/register', [CompanyController::class, 'companyRegister'])->name('companyRegister');
    Route::get('/companies/{id}', [CompanyController::class, 'showCompanyInfo'])->name('company_info');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'showCompanyUpdate'])->name('company_edit');
    Route::post('/companies/{id}/update', [CompanyController::class, 'updateCompany'])->name('company_update');
    Route::delete('/companies/{id}/delete', [CompanyController::class, 'deleteCompany'])->name('company_delete');
    Route::get('/company', [CompanyController::class, 'search'])->name('company.search');


});

Route::middleware('auth')->group(function () {
    Route::get('/offers', [OfferController::class, 'show'])->name(name: 'offer_list');
    Route::get('/offers/register', [OfferController::class, 'showOfferRegister'])->name('offer_register');
    Route::post('/offers/register', [OfferController::class, 'offerRegister'])->name('offerRegister');
    Route::get('/offers/{id}', [OfferController::class, 'showOfferInfo'])->name('offer_info');
    Route::get('/offers/{id}/edit', [OfferController::class, 'showOfferUpdate'])->name('offer_edit');
    Route::post('/offers/{id}/update', [OfferController::class, 'updateOffer'])->name('offer_update');
    Route::delete('/offers/{id}/delete', [OfferController::class, 'deleteOffer'])->name('offer_delete');
});

// Gestion des utilisateurs (Étudiants & Pilotes)
Route::middleware('auth')->group(function () {
    Route::get('/account/students', [UserManagementController::class, 'show'])->name('students_list');
    Route::get('/account/pilots', [UserManagementController::class, 'show'])->name('pilots_list');
    Route::get('/account/{role}/register', [UserManagementController::class, 'showUserRegister'])->name('user_register');
    Route::post('/account/users/register', [UserManagementController::class, 'userRegister'])->name('userRegister');
    Route::get('/account/{role}/{id}', [UserManagementController::class, 'showUserInfo'])->name('user_info');
    Route::get('/account/{role}/{id}/edit', [UserManagementController::class, 'showUserUpdate'])->name('user_edit');
    Route::post('/account/users/{id}/update', [UserManagementController::class, 'updateUser'])->name('user_update');
    Route::delete('/account/users/{id}/delete', [UserManagementController::class, 'deleteUser'])->name('user_delete');
});

