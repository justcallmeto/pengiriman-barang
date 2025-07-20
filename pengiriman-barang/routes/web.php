<?php

use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

// Rute untuk language switcher
// Route::get('locale/{locale}', [LocaleController::class, 'switch'])
//     ->name('filament.admin.locale.switch');


// Route::get('/', function () {
//     return view('index');
// });


Route::get('/', [DeliveryController::class, 'index'])->name('home'); //route untuk home
Route::get('/api/search', [DeliveryController::class, 'search']); //route buat fetch api dari js karena pake js

// Route untuk view invoice di browser
Route::get('/delivery/{id}/invoice/view', function ($id) {
    $delivery = \App\Models\Delivery::findOrFail($id);
    return view('invoice', ['record' => $delivery]);
})->name('delivery.invoice.view');

// Route untuk download PDF langsung
Route::get('/delivery/{id}/invoice/pdf', function ($id) {
    $delivery = \App\Models\Delivery::findOrFail($id);
    
    $pdf = Pdf::loadView('invoice', ['record' => $delivery])
        ->setPaper('a4', 'portrait')
        ->setOptions(['defaultFont' => 'sans-serif']);
    
    return $pdf->download('invoice-' . $delivery->delivery_code . '.pdf');
})->name('delivery.invoice.pdf');