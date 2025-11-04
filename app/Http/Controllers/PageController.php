<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONTROLADOR PRINCIPAL DE LA TIENDA
    |--------------------------------------------------------------------------
    | Nuria Rodríguez Vindel
    | Este controlador devuelve el contenido o las vistas de las distintas
    | páginas del sitio: inicio, detalles, contacto y ofertas.
    */

    // Página principal
    public function home() {
        return "🛍️ Bienvenida a La Tienda de la Nuri — donde cada oferta tiene su encanto ✨";
    }

    // Página de detalles
    public function details() {
        return "📦 Aquí encontrarás los detalles de nuestros productos favoritos 💖";
    }

    // Página de contacto
    public function contact() {
        return view('contact');
    }

    // Página de ofertas
    public function offers() {
        return view('offers');
    }
}
