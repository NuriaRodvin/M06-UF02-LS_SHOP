<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /* ================================
       Helpers privados (trabajan con sesión)
       ================================ */

    /** Obtiene el carrito desde la sesión o devuelve [] si no existe */
    private function getCart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }

       /** Guarda el carrito actualizado en la sesión */
    private function saveCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    // ==========================
    //  PÁGINA DEL CARRITO (INDEX)
    // ==========================
    /**
     * Muestra el carrito y calcula el total.
     */
    public function index(Request $request)
    {
        $cart  = $this->getCart($request);
        // Suma total = precio * cantidad de cada producto
        $total = collect($cart)->sum(fn ($i) => $i['price'] * $i['qty']);

        return view('cart', [
            'cart'  => $cart,
            'total' => $total,
        ]);
    }

    // ==========================
    //  AÑADIR AL CARRITO
    // ==========================
    /**
     * Añade un producto al carrito.
     * Si ya existe, aumenta su cantidad.
     */
    public function add(Request $request, Product $product)
    {
        $cart = $this->getCart($request);
        $qty  = max(1, (int) $request->input('qty', 1));

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->nombre,
                'price'    => (float) $product->precio,
                'qty'      => $qty,
                'category' => optional($product->category)->nombre ?? 'Sin categoría',
            ];
        }

        $this->saveCart($request, $cart);

        return back()->with('ok', '🛒 Producto añadido al carrito');
    }

    // ==========================
    //  ELIMINAR PRODUCTO
    // ==========================
    /**
     * Elimina un producto entero del carrito.
     */
    public function remove(Request $request, Product $product)
    {
        $cart = $this->getCart($request);
        unset($cart[$product->id]);  // borra la línea

        $this->saveCart($request, $cart);

        return back()->with('ok', '❌ Producto eliminado del carrito');
    }

    // ==========================
    //  VACIAR CARRITO
    // ==========================
    public function clear(Request $request)
    {
        $this->saveCart($request, []);
        return back()->with('ok', '🧹 Carrito vaciado');
    }
}

/*
ANOTACIONES PARA ESTUDIAR

***** CARTCONTROLLER

 Controlador encargado de gestionar el CARRITO de la tienda.

 Importante:
 - NO guarda nada en la base de datos.
 - Usa la SESIÓN de Laravel para almacenar el carrito.
 - Cada usuario/navegador tendrá su propio carrito independiente.

 Estructura del array $cart guardado en sesión:
 $cart = [
     product_id => [
         'id'       => (int)   // id del producto
         'name'     => (string)// nombre del producto
         'price'    => (float) // precio unitario
         'qty'      => (int)   // cantidad
         'category' => (string)// nombre de la categoría (solo informativo)
     ],
     ...
 ];

 Rutas relacionadas (web.php):
 - GET  /cart              -> index()  (ver contenido del carrito)
 - POST /cart/add/{product}    -> add()    (añadir producto)
 - POST /cart/remove/{product} -> remove() (eliminar 1 producto concreto)
 - POST /cart/clear            -> clear()  (vaciar todo el carrito)

*/
