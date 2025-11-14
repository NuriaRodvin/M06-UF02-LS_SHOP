<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

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
| /details -> página de “presentación” de la sección
| (vista details_index.blade.php)
*/
Route::get('/details', [PageController::class, 'detailsSection'])->name('details.section');

/*
|----------------------------------------------
| DETALLES DE UN PRODUCTO (CRUD en /details/{id})
|----------------------------------------------
| Esta ruta usa el id para saber qué producto mostrar/editar.
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
| CATÁLOGO DE PRODUCTOS “MODO AMAZON”
|----------------------------------------------
| /products -> grid con tarjetas, filtros y paginación.
*/
Route::get('/products', [PageController::class, 'productsCatalog'])->name('products.catalog');

/*
|----------------------------------------------
| FORMULARIO DE INSERCIÓN (INSERT)
|----------------------------------------------
| /products/create -> formulario de alta
*/
Route::get('/products/create', [PageController::class, 'createProduct'])->name('products.create');
Route::post('/products',        [PageController::class, 'storeProduct'])->name('products.store');

// Rutas de contacto y ofertas (como ya tenías antes de hacer esta tarea 5)
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/offers',  [PageController::class, 'offers'])->name('offers');

// === EXTRA 0,25 ptos: resource sin interferir con lo anterior ===
Route::resource('/shop', ShopController::class);

// --- Carrito (todas con CartController) ---
Route::get('/cart',                    [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}',     [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}',  [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear',             [CartController::class, 'clear'])->name('cart.clear');
