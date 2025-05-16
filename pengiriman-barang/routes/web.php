<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

// Rute untuk language switcher
// Route::get('locale/{locale}', [LocaleController::class, 'switch'])
//     ->name('filament.admin.locale.switch');
Route::get('/', function () {
    return view('welcome');
});
