<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
Route::get('/', function () {
    return view('welcome');
});





Route::get('/', [BookingController::class, 'index'])->name('booking.index');


Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');


Route::get('/thankyou/{id}', [BookingController::class, 'thankyou'])->name('thankyou');