<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importo mis modelos para poder usarlos en este controlador
use App\Models\Product;   // <- Modelo de productos
use App\Models\Category;  // <- Modelo de categorías

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
    |
    | En la Tarea #5 añado el CRUD:
    |   - Insert   (crear nuevos productos)
    |   - Update   (editar productos desde /details)
    |   - Delete   (borrar productos desde /details)
    |   - Envío de filtros entre vistas (home <-> details)
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
        | Importante: uso ->with('category') para que Eloquent cargue
        | también la categoría de cada producto (relación belongsTo).
        */
        $query = Product::with('category');

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
        | Ordeno de menor a mayor precio cuando el usuario lo pide.
        */
        if ($orderPrice) {
            $query->orderBy('precio', 'asc');
        }

        /*
        |------------------------------------------------------------------
        | 6) Ejecuto la consulta y obtengo la colección de productos
        |------------------------------------------------------------------
        */
        $products = $query->get();

        /*
        |------------------------------------------------------------------
        | 7) Devuelvo la vista "home" pasándole los datos
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
        | el detalle completo se ve en /home -> "Ver detalles ✏️".
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
- `detailsSection()` es la portada general de la sección Detalles.
- `details()` muestra los detalles de un producto (CRUD Update/Delete).
- `contact()` y `offers()` devuelven vistas Blade simples con texto.
- `createProduct()` y `storeProduct()` me permiten hacer el INSERT.

 Ampliación en la Tarea #4
----------------------------------------------------
- El método `home()` recupera los productos desde la base de datos
  usando el modelo `Product`.
- Se añaden filtros por categoría y una opción para ordenar por precio.
- Los datos se envían a la vista `home.blade.php` con arrays asociativos.

 Ampliación en la Tarea #5 (CRUD)
----------------------------------------------------
- `detailsSection()` sirve para que el menú "Detalles" tenga su propia
  página informativa, sin depender de ningún id.
- `details()` recibe el id del producto desde /home.
- `updateProduct()` actualiza cualquier campo del producto.
- `deleteProduct()` permite eliminar el producto por completo.
- `createProduct()` y `storeProduct()` permiten insertar uno nuevo.
- Mantengo los filtros entre vistas para que la experiencia sea mejor.

 Buenas prácticas usadas
----------------------------------------------------
- Separé la lógica de negocio en el controlador y la vista en Blade.
- Usé validación con `$request->validate()` para controlar errores.
- Mantengo mis comentarios y emojis para entender mejor el código :)

====================================================================
*/
