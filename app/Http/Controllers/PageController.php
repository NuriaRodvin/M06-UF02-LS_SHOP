<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;      // Para poder leer los datos del formulario (GET/POST)
use App\Models\Product;           // <- Modelo de productos (tabla "products")
use App\Models\Category;          // <- Modelo de categorías (tabla "categories")

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONTROLADOR PRINCIPAL DE LA TIENDA
    |--------------------------------------------------------------------------
    | Nuria Rodríguez Vindel
    | Este controlador devuelve el contenido o las vistas de las distintas
    | páginas del sitio: inicio, detalles, contacto y ofertas.
    |
    | En la Tarea #4, la página más importante es "home", porque ahí
    | tengo que mostrar la tabla con los productos de la base de datos,
    | con filtros por categoría y una opción de ordenación por precio.
    */

    // =======================
    // PÁGINA PRINCIPAL (HOME)
    // =======================
    public function home(Request $request)
    {
        /*
        |------------------------------------------------------------------
        | 1) Recupero todas las categorías desde la BD
        |------------------------------------------------------------------
        | Las necesito para pintar los checkboxes de filtrado.
        | Las ordeno por nombre para que se vean bonitas en el menú.
        */
        $categories = Category::orderBy('nombre')->get();

        /*
        |------------------------------------------------------------------
        | 2) Leo los filtros que vienen del formulario (GET)
        |------------------------------------------------------------------
        | - categories[]  -> array de IDs de categorías marcadas
        | - order_price   -> checkbox para decidir si ordeno por precio
        |
        | Si el usuario entra por primera vez sin filtrar nada,
        | $selectedCategories estará vacío -> mostraré todas.
        */
        $selectedCategories = $request->input('categories', []); // puede ser []
        $orderPrice        = $request->boolean('order_price');  // true/false

        /*
        |------------------------------------------------------------------
        | 3) Construyo la consulta base de productos
        |------------------------------------------------------------------
        | Importante:
        | - with('category') para que Eloquent cargue también la categoría
        |   de cada producto (relación belongsTo).
        | - where('activo', 1) para mostrar solo productos activos
        |   (así no enseño cosas ocultas o agotadas).
        */
        $query = Product::with('category')
            ->where('activo', 1);

        /*
        |------------------------------------------------------------------
        | 4) Aplico filtro por categoría (si el usuario ha marcado algo)
        |------------------------------------------------------------------
        | Si el array está vacío, significa "todas las categorías",
        | así que en ese caso NO añado ningún whereIn.
        */
        if (!empty($selectedCategories)) {
            $query->whereIn('category_id', $selectedCategories);
        }

        /*
        |------------------------------------------------------------------
        | 5) Aplico ordenación por precio (si el checkbox está marcado)
        |------------------------------------------------------------------
        | Podría hacer más opciones, pero para esta tarea basta con
        | ordenar de menor a mayor precio cuando el usuario lo pida.
        */
        if ($orderPrice) {
            $query->orderBy('precio', 'asc');
        }

        /*
        |------------------------------------------------------------------
        | 6) Ejecuto la consulta y obtengo la colección de productos
        |------------------------------------------------------------------
        | Aquí ya tengo en $products todos los registros que cumplen
        | los filtros anteriores (o todos, si no se ha filtrado nada).
        */
        $products = $query->get();

        /*
        |------------------------------------------------------------------
        | 7) Devuelvo la vista "home" pasándole los datos
        |------------------------------------------------------------------
        | En la vista usaré:
        |   - $categories          -> para los checkboxes
        |   - $products            -> para pintar la tabla
        |   - $selectedCategories  -> para saber qué estaba marcado
        |   - $orderPrice          -> para recordar el estado del checkbox
        |
        | Uso compact() porque queda más limpio y tal cual lo explico
        | en los comentarios de la parte de abajo.
        */
        return view('home', compact(
            'categories',
            'products',
            'selectedCategories',
            'orderPrice'
        ));
    }

    // ===================
    // PÁGINA DE DETALLES
    // ===================
    public function details()
    {
        /*
        | Aquí podría mostrar detalles más completos de algunos productos
        | (descripción larga, etc.). De momento utilizo una vista Blade
        | sencilla, como en las tareas anteriores.
        */
        return view('details');
    }

    // ===================
    // PÁGINA DE CONTACTO
    // ===================
    public function contact()
    {
        return view('contact');
    }

    // ==================
    // PÁGINA DE OFERTAS
    // ==================
    public function offers()
    {
        return view('offers');
    }
}

/*
====================================================================
 EXPLICACIÓN GENERAL DEL CONTROLADOR (PageController)
====================================================================

Este controlador gestiona las páginas principales de mi aplicación
Laravel (home, details, contact, offers).

 Estructura básica
----------------------------------------------------
- Cada método representa una ruta o página del sitio.
- `home()` carga la vista principal donde se mostrarán los productos.
- `details()` muestra detalles de los productos o secciones.
- `contact()` y `offers()` devuelven vistas Blade simples con texto.

 Ampliación en la Tarea #4
----------------------------------------------------
- El método `home()` ahora recupera los productos desde la base de datos
  usando el modelo `Product`.
- Se añaden filtros por categoría y una opción para ordenar por precio.
- Los datos se envían a la vista `home.blade.php` mediante compact().

 Buenas prácticas usadas
----------------------------------------------------
- Separé la lógica de negocio en el controlador y la visual en las vistas.
- Usé nombres claros y comentarios para que se entienda cada parte.
- Incluí emojis y frases amables para que el código sea más divertido 

====================================================================
*/

