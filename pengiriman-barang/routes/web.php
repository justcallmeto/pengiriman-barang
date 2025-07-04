<?php

use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

// Rute untuk language switcher
// Route::get('locale/{locale}', [LocaleController::class, 'switch'])
//     ->name('filament.admin.locale.switch');


// Route::get('/', function () {
//     return view('index');
// });


Route::get('/', [DeliveryController::class, 'index'])->name('home'); //route untuk home
Route::get('/api/search', [DeliveryController::class, 'search']); //route buat fetch api dari js karena pake js