<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;


/*
// === Rutas del ejercicio (CS02) ===
Route::get('/',          [PageController::class, 'home'])->name('home');
Route::get('/home',      [PageController::class, 'home']);
Route::get('/details',   [PageController::class, 'details']);
Route::get('/contact',   [PageController::class, 'contact']);
Route::get('/offers',    [PageController::class, 'offers']);
*/


// Ruta principal
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/home', [PageController::class, 'home'])->name('home');

/*
|----------------------------------------------
| SECCIÓN GENERAL DE DETALLES (SIN ID)
|----------------------------------------------
| Esta ruta se usa cuando pulso en el menú lateral
| "Detalles". No necesito ningún id, solo quiero
| mostrar la página bonita de presentación.
|
| Usa el método detailsSection() del PageController
| y la vista resources/views/details_index.blade.php
*/
Route::get('/details', [PageController::class, 'detailsSection'])
    ->name('details.section');

/*
|----------------------------------------------
| DETALLES DE UN PRODUCTO (CRUD en /details/{id})
|----------------------------------------------
| Ahora la ruta de detalles recibe un {id}
| para saber qué producto mostrar/editar.
|
| OJO: esta ruta va DESPUÉS de /details, porque
| si no, Laravel intentaría interpretar /details
| como si le faltara el id.
*/
Route::get('/details/{id}', [PageController::class, 'details'])->name('details');

/*
|----------------------------------------------
| UPDATE y DELETE del producto (en /details/{id})
|----------------------------------------------
| Usamos los métodos HTTP típicos de REST:
|  - PUT    -> actualizar
|  - DELETE -> borrar
*/
Route::put('/details/{id}', [PageController::class, 'updateProduct'])->name('details.update');
Route::delete('/details/{id}', [PageController::class, 'deleteProduct'])->name('details.delete');

/*
|----------------------------------------------
| FORMULARIO DE INSERCIÓN (INSERT)
|----------------------------------------------
| He decidido poner el formulario en una
| ruta propia /products/create porque es
| lo que suele hacerse en Laravel, creo.
*/
Route::get('/products/create', [PageController::class, 'createProduct'])->name('products.create');
Route::post('/products', [PageController::class, 'storeProduct'])->name('products.store');

// Rutas de contacto y ofertas
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/offers', [PageController::class, 'offers'])->name('offers');

// === EXTRA 0,25 ptos: resource sin interferir con lo anterior ===
Route::resource('/shop', ShopController::class);
