<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VaccinationController;

// Home route (optional)
Route::get('/', function () {
    return view('home');
});

Route::get('/timezone', function () {
    return now(); // This will return the current time in the set timezone
});


// Registration route
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register'])->name('register.submit');


// Search route
Route::get('/search', [VaccinationController::class, 'showSearchForm'])->name('search');
Route::get('/search/status', [VaccinationController::class, 'searchStatus'])->name('search.status');

