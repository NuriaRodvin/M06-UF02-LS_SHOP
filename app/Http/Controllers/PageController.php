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
    | Este controlador gestiona la visualización de las diferentes páginas 
    | del sitio web “La Tienda de la Nuri”. Cada método devuelve la vista 
    | correspondiente usando el motor de plantillas Blade. 
    |-------------------------------------------------------------------------- 
    */

    // Página principal
    public function home() {
        // Devuelve la vista principal con el layout Blade aplicado
        return view('home');
    }

    // Página de detalles
    public function details() {
        // Muestra información de algunos productos destacados
        return view('details');
    }

    // Página de contacto
    public function contact() {
        // Carga la vista de contacto con el diseño Blade
        return view('contact');
    }

    // Página de ofertas
    public function offers() {
        // Devuelve la vista con las ofertas y promociones activas
        return view('offers');
    }
}
