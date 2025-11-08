<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Muestra la página principal (/ o /home)
     */
    public function index()
    {
        return "🛍️ Bienvenida a La Tienda de la Nuri — donde cada oferta tiene su encanto ✨";
    }

    /**
     * Muestra la página de contacto (/shop/create)
     */

    public function create()
    {
        return view('contact'); // muestra la vista verde de contacto
    }

    /**
     * Guarda algo
     */
    public function store(Request $request)
    {
        return "Guardando nuevo producto... (solo demostración)";
    }

    /*
     * Muestra la página de detalles (/shop/{id})
     */
    public function show(string $id)
    {
        return "📦 Detalles del producto #{$id} — cada detalle cuenta 💖";
    }

    /**
     * Muestra la página de ofertas (/shop/{id}/edit)
     */
    public function edit(string $id)
    {
        return view('offers'); // muestra la vista rosa de ofertas
    }

    /**
     * Actualiza un recurso
     */
    public function update(Request $request, string $id)
    {
        return "Actualizando producto #{$id}...";
    }

    /**
     * Elimina un recurso
     */
    public function destroy(string $id)
    {
        return "Eliminando producto #{$id}...";
    }
}
