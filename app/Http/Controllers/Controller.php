<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}



/*
   Controlador base de Laravel.

   - Todos los controladores del proyecto heredan de aquí.
   - Incluye dos “traits” muy usados:
       • AuthorizesRequests  → permite usar autorizaciones (políticas).
       • ValidatesRequests   → permite validar formularios fácilmente.
   - No contiene lógica propia: solo sirve como clase padre
     para PageController, CartController, etc.
*/
