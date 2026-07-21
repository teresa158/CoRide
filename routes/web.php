<?php

use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');
