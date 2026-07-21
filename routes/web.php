<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Routes pour les Trajets
Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');
Route::get('/trajets/creer', [TrajetController::class, 'create'])->name('trajets.create');
Route::post('/trajets', [TrajetController::class, 'store'])->name('trajets.store');
Route::get('/trajets/{trajet}', [TrajetController::class, 'show'])->name('trajets.show');

// Route de réservation
Route::post('/trajets/{trajet}/reservations', [ReservationController::class, 'store'])->name('reservations.store');
