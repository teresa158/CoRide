<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntrepriseController;

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

// Route Dashboard (espace personnel)
Route::get('/dashboard/{user}', [DashboardController::class, 'show'])->name('dashboard');

// Actions sur les réservations
Route::post('/reservations/{reservation}/accepter', [ReservationController::class, 'accepter'])->name('reservations.accepter');
Route::post('/reservations/{reservation}/refuser', [ReservationController::class, 'refuser'])->name('reservations.refuser');
Route::post('/reservations/{reservation}/annuler', [ReservationController::class, 'annuler'])->name('reservations.annuler');


// Route pour les entreprises
Route::get('/entreprises/{entreprise}', [EntrepriseController::class, 'show'])->name('entreprises.show');