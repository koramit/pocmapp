<?php

use App\Http\Controllers\Auth\SSOAuthenticatedSessinController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// auth
Route::post('/login', [SSOAuthenticatedSessinController::class, 'create']); // api then except csrf
Route::post('/logout', [SSOAuthenticatedSessinController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/sso/{user}', [SSOAuthenticatedSessinController::class, 'store'])->middleware('signed')->name('sso'); // login user the redirect to HOME

// feature
Route::get('/dashboard', DashboardController::class)->middleware('auth')->name('dashboard');
