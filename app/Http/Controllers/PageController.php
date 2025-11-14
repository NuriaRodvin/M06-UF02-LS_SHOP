<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importo mis modelos para poder usarlos en este controlador
use App\Models\Product;   // <- Modelo de productos
use App\Models\Category;  // <- Modelo de categorías

class PageController extends Controller
{


    // =======================
    // PÁGINA PRINCIPAL (HOME)
    // =======================
    public function home(Request $request)
    {
        /*
        |------------------------------------------------------------------
        | 1. Recupero todas las categorías desde la BD
        |------------------------------------------------------------------
        | Las necesito para pintar los checkboxes de filtrado.
        | Las ordeno por nombre para que se vean bonitas en el menú.
        */
        $categories = Category::orderBy('nombre')->get();

        /*
        |------------------------------------------------------------------
        | 2. Leo los filtros que vienen del formulario (GET)
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
        | 3. Construyo la consulta base de productos
        |------------------------------------------------------------------
        | Importante: uso ->with('category') para que Eloquent cargue
        | también la categoría de cada producto (relación belongsTo).
        */
        $query = Product::with('category');

        /*
        |------------------------------------------------------------------
        | 4. Aplico filtro por categoría (si el usuario ha marcado algo)
        |------------------------------------------------------------------
        | Si el array está vacío, significa "todas las categorías",
        | así que en ese caso NO añado ningún whereIn.
        */
        if (!empty($selectedCategories)) {
            $query->whereIn('category_id', $selectedCategories);
        }

        /*
        |------------------------------------------------------------------
        | 5. Aplico ordenación por precio (si el checkbox está marcado)
        |------------------------------------------------------------------
        | Ordeno de menor a mayor precio cuando el usuario lo pide.
        */
        if ($orderPrice) {
            $query->orderBy('precio', 'asc');
        }

        /*
        |------------------------------------------------------------------
        | 6. Ejecuto la consulta y obtengo la colección de productos
        |------------------------------------------------------------------
        */
        $products = $query->get();

        /*
        |------------------------------------------------------------------
        | 7. Devuelvo la vista "home" pasándole los datos
        |------------------------------------------------------------------
        */
        return view('home', [
            'categories'         => $categories,
            'products'           => $products,
            'selectedCategories' => $selectedCategories,
            'orderPrice'         => $orderPrice,
        ]);
    }

    // ====================================
    // SECCIÓN GENERAL DE DETALLES (SIN ID)
    // ====================================
    public function detailsSection()
    {
        /*
        |------------------------------------------------------------------
        | Este método se usa cuando hago clic en el menú lateral "Detalles".
        | No recibe id, así que aquí NO hago CRUD.
        |
        | La idea es tener una página bonita de presentación con
        | algunos productos destacados y un texto explicando que
        | el detalle completo se ve en /home -> "Ver detalles".
        |
        | La vista se llama "details_index.blade.php".
        */
        return view('details_index');
    }

    // ===================
    // PÁGINA DE DETALLES
    // ===================
    public function details(Request $request, $id)
    {
        /*
        | Aquí ahora la vista de detalles tiene que:
        |  - Recibir el id del producto
        |  - Cargar todos sus datos desde la base de datos
        |  - Mostrar un formulario editable (CRUD Update/Delete)
        |  - Mantener los filtros que venían de /home
        */

        // Recupero el producto o lanzo 404 si no existe
        $product = Product::with('category')->findOrFail($id);

        // Recojo los filtros que venían desde home (para poder volver con ellos)
        $selectedCategories = $request->input('categories', []);
        $orderPrice        = $request->boolean('order_price');

        // Vuelvo a cargar las categorías para poder cambiar de categoría en el form
        $categories = Category::orderBy('nombre')->get();

        return view('details', [
            'product'            => $product,
            'categories'         => $categories,
            'selectedCategories' => $selectedCategories,
            'orderPrice'         => $orderPrice,
        ]);
    }

    // ==========================
    // UPDATE DEL PRODUCTO (CRUD)
    // ==========================
    public function updateProduct(Request $request, $id)
    {
        /*
        | Este método se llama cuando envío el formulario
        | de edición desde /details con el botón "Guardar".
        | Aquí hago:
        |  - Validación de datos (control de errores)
        |  - Actualización del producto
        |  - Redirección de vuelta a /details con mensaje
        */

        // Validación básica de campos
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'precio'      => 'required|numeric|min:0',
            'descripcion' => 'required|string',
            'sku'         => 'nullable|string|max:40',
            'stock'       => 'required|integer|min:0',
            'activo'      => 'required|boolean',
        ]);

        // Busco el producto
        $product = Product::findOrFail($id);

        // Actualizo usando fill y save
        $product->fill($validated);
        $product->save();

        // Mantengo los filtros al volver a /details
        $params = [
            'categories'  => $request->input('categories', []),
            'order_price' => $request->boolean('order_price') ? 1 : 0,
        ];

        // Redirijo de nuevo a la ficha con mensaje de éxito
        return redirect()
            ->route('details', ['id' => $product->id] + $params)
            ->with('status', '✅ Producto actualizado correctamente');
    }

    // ==========================
    // DELETE DEL PRODUCTO (CRUD)
    // ==========================
    public function deleteProduct(Request $request, $id)
    {
        /*
        | Este método se llama desde /details cuando pulso
        | el botón de "Eliminar producto".
        | Aquí borro el producto de la base de datos.
        | Después de borrar, vuelvo a /home manteniendo los filtros
        | que estuvieran activos.
        */

        $product = Product::findOrFail($id);
        $product->delete();

        // Después de borrar, vuelvo a home manteniendo filtros
        $params = [
            'categories'  => $request->input('categories', []),
            'order_price' => $request->boolean('order_price') ? 1 : 0,
        ];

        return redirect()
            ->route('home', $params)
            ->with('status', '🗑️ Producto eliminado correctamente');
    }

    // ==========================
    // FORMULARIO DE INSERCIÓN
    // ==========================
    public function createProduct(Request $request)
    {
        /*
        | Vista donde muestro el formulario para crear
        | un nuevo producto (INSERT).
        */

        $categories = Category::orderBy('nombre')->get();

        // También puedo mantener filtros si vengo desde home
        $selectedCategories = $request->input('categories', []);
        $orderPrice        = $request->boolean('order_price');

        return view('products.create', [
            'categories'         => $categories,
            'selectedCategories' => $selectedCategories,
            'orderPrice'         => $orderPrice,
        ]);
    }

    // ==========================
    // GUARDAR NUEVO PRODUCTO
    // ==========================
    public function storeProduct(Request $request)
    {
        /*
        | Aquí proceso el formulario de creación:
        |  - Valido los datos
        |  - Creo el producto con el modelo Product
        |  - Redirijo a home con un mensajito
        */

        $validated = $request->validate([
            'nombre'      => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'precio'      => 'required|numeric|min:0',
            'descripcion' => 'required|string',
            'sku'         => 'nullable|string|max:40|unique:products,sku',
            'stock'       => 'required|integer|min:0',
            'activo'      => 'required|boolean',
        ]);

        Product::create($validated);

        // Mantengo filtros que venían de home si los había
        $params = [
            'categories'  => $request->input('categories', []),
            'order_price' => $request->boolean('order_price') ? 1 : 0,
        ];

        return redirect()
            ->route('home', $params)
            ->with('status', '✨ Producto creado correctamente');
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

    // ===============================================
    // CATÁLOGO DE PRODUCTOS (MODO AMAZON, cambiado después)
    // ===============================================
    public function productsCatalog(Request $request)
    {
        /*
        |------------------------------------------------------------------
        | Esta página /products es mi "competencia de Amazon" 
        | Aquí muestro los productos en formato tarjeta, con:
        |   - Buscador por nombre (q)
        |   - Filtro por categoría (category_id)
        |   - Ordenación por precio (order_price)
        |
        | Importante: aquí NO hago CRUD directamente;
        |             el CRUD completo sigue en /details/{id}
        |             y el INSERT en /products/create.
        */

        // 1. Cargo todas las categorías para el filtro del <select>
        $categories = Category::orderBy('nombre')->get();

        // 2. Leo parámetros de la URL (GET)
        $search     = $request->input('q', '');             // texto que escribe la persona
        $categoryId = $request->input('category_id');       // puede venir null
        $orderPrice = $request->boolean('order_price');     // true/false

        // 3. Construyo la consulta base
        $query = Product::with('category');

        // 4. Filtro por nombre si han escrito algo en el buscador
        if ($search !== '') {
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        // 5. Filtro por categoría si han elegido alguna en el select
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // 6. Ordenación por precio (de menor a mayor) si han marcado el checkbox
        if ($orderPrice) {
            $query->orderBy('precio', 'asc');
        }

        // 7. Ejecuto la consulta con paginación (tipo Amazon: por páginas)
        $products = $query->paginate(9)->withQueryString();
        // withQueryString() hace que la paginación mantenga los filtros en la URL

        // 8. Devuelvo la vista del catálogo
        return view('products.index', [
            'categories'  => $categories,
            'products'    => $products,
            'search'      => $search,
            'categoryId'  => (int) $categoryId,
            'orderPrice'  => $orderPrice,
        ]);
    }

    // ===================
    // PÁGINA DEL CARRITO
    // ===================
    public function cart()
    {
        /*
        |--------------------------------------------------------------
        | Carrito (demo visual)
        |--------------------------------------------------------------
        | De momento es una página informativa (sin lógica de compra).
        | Más adelante puedo guardar artículos en sesión y mostrar
        | cantidades, total, etc. Por ahora solo muestro la vista.
        */
        return view('cart');
    }
}

/*
===========================================================
 APUNTES / DOCUMENTACIÓN DE PageController
===========================================================

Este controlador gestiona TODAS las páginas principales de la tienda.

────────────────────────────────────────────
1. Página principal (home)
────────────────────────────────────────────
Método: home()

Funciones:
- Carga todas las categorías.
- Lee filtros enviados por GET:
    categories[] = categorías marcadas
    order_price  = orden ascendente por precio
- Construye una consulta Eloquent con:
    ->with('category')   (carga relación)
    ->whereIn()          (filtro por categorías)
    ->orderBy()          (si hay ordenación)
- Devuelve la vista home.blade.php con todos los datos.

Usado en Tarea 4.

────────────────────────────────────────────
2. detailsSection()
────────────────────────────────────────────
Página /details sin id.
Sirve como portada decorativa con tarjetas fijas.

────────────────────────────────────────────
3. details($id)
────────────────────────────────────────────
Muestra la ficha de un producto concreto.

Pasos:
- Recupera el producto con category.
- Recupera categorías para el <select>.
- Mantiene filtros previos para volver atrás.

Usado en Tarea 5 (CRUD Update/Delete).

────────────────────────────────────────────
4. updateProduct()
────────────────────────────────────────────
Actualiza un producto ya existente:
- Valida datos.
- Busca el producto.
- fill() + save().
- Redirige de vuelta manteniendo filtros.

────────────────────────────────────────────
5. deleteProduct()
────────────────────────────────────────────
Elimina un producto de la base de datos.
Redirige a home con filtros y mensaje.

────────────────────────────────────────────
6. createProduct()
────────────────────────────────────────────
Carga formulario para crear un nuevo producto.

────────────────────────────────────────────
7. storeProduct()
────────────────────────────────────────────
Guarda un nuevo producto en la BD.
Valida, inserta y redirige.

────────────────────────────────────────────
8. contact() / offers()
────────────────────────────────────────────
Vistas estáticas.

────────────────────────────────────────────
9. productsCatalog()
────────────────────────────────────────────
Catálogo visual tipo Amazon:
- Buscador (q)
- Filtro por categoría
- Orden por precio
- Paginación (9 por página)
- Mantiene parámetros con withQueryString()

Vista: products/index.blade.php

────────────────────────────────────────────
10. cart()
────────────────────────────────────────────
Versión inicial de carrito (ahora reemplazado por CartController).
Se deja como referencia de la práctica original.

────────────────────────────────────────────
 Resumen rápido
────────────────────────────────────────────
home()              → filtros + tabla
detailsSection()    → portada detalles
details()           → ficha editable
updateProduct()     → actualizar
deleteProduct()     → borrar
createProduct()     → formulario nuevo
storeProduct()      → insertar
productsCatalog()   → catálogo tarjetas
contact(), offers() → simples
cart()              → demo antigua



    /*
    |--------------------------------------------------------------------------
    | CONTROLADOR PRINCIPAL DE LA TIENDA
    |--------------------------------------------------------------------------
    | Este controlador devuelve el contenido o las vistas de las distintas
    | páginas del sitio: inicio, detalles, contacto y ofertas.
    |
    | En la Tarea #4, la página más importante es "home", porque ahí
    | tengo que mostrar la tabla con los productos de la base de datos,
    | con filtros por categoría y una opción de ordenación por precio.
    |
    | En la Tarea #5 añado el CRUD:
    |   - Insert   (crear nuevos productos)
    |   - Update   (editar productos desde /details)
    |   - Delete   (borrar productos desde /details)
    |   - Envío de filtros entre vistas (home <-> details)
    */
