<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController; 

// === Rutas del ejercicio (CS02) ===
Route::get('/',          [PageController::class, 'home']);
Route::get('/home',      [PageController::class, 'home']);
Route::get('/details',   [PageController::class, 'details']);
Route::get('/contact',   [PageController::class, 'contact']);
Route::get('/offers',    [PageController::class, 'offers']);

// === EXTRA 0,25 ptos: resource sin interferir con lo anterior ===
Route::resource('/shop', ShopController::class);
