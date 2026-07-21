<?php

use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');
Route::get('/trajets/{trajet}', [TrajetController::class, 'show'])->name('trajets.show');

// Route de réservation
Route::post('/trajets/{trajet}/reservations', [ReservationController::class, 'store'])->name('reservations.store');