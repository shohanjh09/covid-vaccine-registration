<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VaccinationController;

// Home route (optional)
Route::get('/', function () {
    return view('welcome');
});

// Registration route
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);

// Search route
Route::get('/search', [VaccinationController::class, 'showSearchForm'])->name('search');
Route::get('/search/status', [VaccinationController::class, 'search'])->name('search.status');
