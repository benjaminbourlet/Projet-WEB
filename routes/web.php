<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;



// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard
Route::get('/dashboard/{id}', function () {
    return view('account/dashboard');
})->middleware('auth')->name('dashboard');

// Profil utilisateur
Route::get('/profile/{id}', [ProfileController::class, 'show'])
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

Route::middleware('auth')->group(function () {
    Route::get('/offers/{offer_id}/apply', [ApplicationController::class, 'showApplicationRegister'])->name('offer_apply');
    Route::post('/offers/{offer_id}/apply', [ApplicationController::class, 'applicationRegister'])->name('applicationRegister');
    Route::get('/my_applications/{user_id}', [ApplicationController::class, 'show'])->name('applications_show');
    Route::get('/my_applications/{user_id}/{offer_id}', [ApplicationController::class, 'showApplicationInfo'])->name('applications_info');
    Route::get('/students/{user_id}/applications/{offer_id}', [ApplicationController::class, 'showApplicationInfo'])->name('applications_info_user');
    Route::get('/students/{user_id}/applications/{offer_id}/edit', [ApplicationController::class, 'showApplicationUpdate'])->name('applications_edit');
    Route::post('/students/{user_id}/applications/{offer_id}/edit', [ApplicationController::class, 'updateApplication'])->name('applications_update');

});

// Gestion des utilisateurs (Étudiants & Pilotes)
Route::middleware('auth')->group(function () {
    Route::get('/students', [UserController::class, 'show'])->name('students_list');
    Route::get('/pilots', [UserController::class, 'show'])->name('pilots_list');
    Route::get('/{role}/register', [UserController::class, 'showUserRegister'])->name('user_register');
    Route::post('/users/register', [UserController::class, 'userRegister'])->name('userRegister');
    Route::get('/{role}/{id}', [UserController::class, 'showUserInfo'])->name('user_info');
    Route::get('/{role}/{id}/edit', [UserController::class, 'showUserUpdate'])->name('user_edit');
    Route::post('/users/{id}/update', [UserController::class, 'updateUser'])->name('user_update');
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('user_delete');
});
