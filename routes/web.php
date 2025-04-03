<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HomeController;



// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Accueil
Route::get('/', [HomeController::class, 'homeControl'])->name('home');

Route::get('/mentions-legales', function () {
    return view('legal_mention');
})->name('mentions-legales');

Route::get('/qui_sommes_nous', function () {
    return view('qui_sommes_nous');
})->name('qui_sommes_nous');

Route::get('/on_recrute', function () {
    return view('on_recrute');
})->name('on_recrute');


// Dashboard
use App\Http\Controllers\DashboardController;

Route::get('/dashboard/{id}', [DashboardController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

// Profil utilisateur
Route::get('/profile/{id}', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/offers', [OfferController::class, 'show'])->name('offer_list');
    Route::get('/offers/register', [OfferController::class, 'showOfferRegister'])->name('offer_register');
    Route::post('/offers/register', [OfferController::class, 'offerRegister'])->name('offerRegister');
    Route::get('/offers/{id}/{title}', [OfferController::class, 'showOfferInfo'])->name('offer_info');
    Route::get('/offers/{id}/{title}/edit', [OfferController::class, 'showOfferUpdate'])->name('offer_edit');
    Route::post('/offers/{id}/update', [OfferController::class, 'updateOffer'])->name('offer_update');
    Route::delete('/offers/{id}/delete', [OfferController::class, 'deleteOffer'])->name('offer_delete');
    Route::get('/offers/search', [OfferController::class, 'search'])->name('offer.search');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/companies/{company_id}/evaluate', [EvaluationController::class, 'showEvaluationsCreate'])->name('evaluations_create');
    Route::post('/companies/{company_id}/evaluate/create', [EvaluationController::class, 'evaluationsCreate'])->name('evaluationsCreate');
    Route::get('/companies/{company_id}/evaluations', [EvaluationController::class, 'showEvaluationsCompany'])->name('evaluations_company_list');
    Route::get('/my_evaluations/{user_id}', [EvaluationController::class, 'showEvaluations'])->name('evaluations_user_list');
    Route::delete('/evaluations/{user_id}/remove/{company_id}', [EvaluationController::class, 'removeEvaluations'])->name('evaluations_remove');
    Route::get('/evaluations', [EvaluationController::class, 'showAllEvaluations'])->name('evaluations_all');
});

Route::middleware('auth')->group(function () {
    Route::get('/companies', [CompanyController::class, 'show'])->name('company_list');
    Route::get('/companies/register', [CompanyController::class, 'showCompanyRegister'])->name('company_register');
    Route::post('/companies/register', [CompanyController::class, 'companyRegister'])->name('companyRegister');
    Route::get('/companies/{id}', [CompanyController::class, 'showCompanyInfo'])->name('company_info');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'showCompanyUpdate'])->name('company_edit');
    Route::post('/companies/{id}/update', [CompanyController::class, 'updateCompany'])->name('company_update');
    Route::delete('/companies/{id}/delete', [CompanyController::class, 'deleteCompany'])->name('company_delete');
    Route::get('/companies/{id}/offers', [CompanyController::class, 'showOffers'])->name('company_offers');
    Route::get('/companies/search', [CompanyController::class, 'search'])->name('company.search');
});

Route::middleware('auth')->group(function () {
    Route::get('/offers/{offer_id}/{title}/apply', [ApplicationController::class, 'showApplicationRegister'])->name('offer_apply');
    Route::post('/offers/{offer_id}/apply/create', [ApplicationController::class, 'applicationRegister'])->name('applicationRegister');
    Route::get('/my_applications/{user_id}', [ApplicationController::class, 'show'])->name('applications_list');
    Route::get('/students/{user_id}/applications', [ApplicationController::class, 'show'])->name('applications_list_user');
    Route::get('/my_applications/{user_id}/{offer_id}', [ApplicationController::class, 'showApplicationInfo'])->name('applications_info');
    Route::get('/students/{user_id}/applications/{offer_id}', [ApplicationController::class, 'showApplicationInfo'])->name('applications_info_user');
    Route::get('/students/{user_id}/applications/{offer_id}/edit', [ApplicationController::class, 'showApplicationUpdate'])->name('applications_edit');
    Route::post('/students/{user_id}/applications/{offer_id}/edit', [ApplicationController::class, 'updateApplication'])->name('applications_update');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist/{user_id}', [WishlistController::class, 'index'])->name('wishlists_list');
    Route::get('/students/{user_id}/wishlist', [WishlistController::class, 'index'])->name('wishlists_list_user');
    Route::post('/wishlist/{user_id}/add/{offer_id}', [WishlistController::class, 'addToWishlist'])->name('wishlist_add');
    Route::post('/wishlist/{user_id}/remove/{offer_id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist_remove');
});

// Gestion des utilisateurs (Étudiants & Pilotes)
Route::middleware('auth')->group(function () {
    Route::get('/students', [UserController::class, 'show'])->name('students_list');
    Route::get('/pilots', [UserController::class, 'show'])->name('pilots_list');
    Route::get('/{role}/search', [UserController::class, 'search'])->name('user.search');
    Route::get('/{role}/register', [UserController::class, 'showUserRegister'])->name('user_register');
    Route::post('/users/register', [UserController::class, 'userRegister'])->name('userRegister');
    Route::get('/{role}/{id}', [UserController::class, 'showUserInfo'])->name('user_info');
    Route::get('/{role}/{id}/edit', [UserController::class, 'showUserUpdate'])->name('user_edit');
    Route::post('/users/{id}/update', [UserController::class, 'updateUser'])->name('user_update');
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('user_delete');
});