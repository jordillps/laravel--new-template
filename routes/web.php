<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para cambio de idioma
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->name('locale.switch')
    ->where('locale', '[a-z]{2}');
    
Route::get('/locale/reset', [LocaleController::class, 'reset'])
    ->name('locale.reset');
