@extends('layouts.app')

{{-- Color principal de esta página (se usa en el layout con @yield('accent')) --}}
@section('accent', '#d92332')

@section('title', 'Inicio')

@section('content')
    <!-- =======================================================
        PÁGINA PRINCIPAL DE LA TIENDA
        Aquí muestro la bienvenida con mi estilo original,
        y además añado (como pide la Tarea #4) la parte
        de productos de la base de datos con filtros y ordenación.
    ======================================================== -->

    <h1>🏪 Bienvenida a <strong>La Tienda de la Nuri</strong></h1>
    <p>Donde cada oferta tiene su encanto ✨ y cada click te acerca a algo que te encanta 💖.</p>

    <div class="card">
        <h2>¿Qué encontrarás?</h2>
        <ul>
            <li>💻 Tecnología útil y bonita</li>
            <li>👗 Moda con estilo y envío gratis</li>
            <li>🐾 Mimos para tus mascotas</li>
            <li>🏠 Cosas del hogar con descuentos irresistibles</li>
        </ul>
    </div>

    <p>Explora el menú lateral para descubrir más. ¡Bienvenida a tu nueva tienda favorita! 🌸</p>

    <!-- =======================================================
        A PARTIR DE AQUÍ EMPIEZA LA PARTE DE LA TAREA #4
        - Mostrar productos reales desde la base de datos (ls_shop)
        - Permitir filtrar por categoría
        - Permitir ordenar por precio
        Intento que el diseño siga mi estilo anterior, con emojis 
    ======================================================== -->

    <div class="card" style="margin-top: 30px;">
        <h2>🧾 Catálogo de productos de mi base de datos</h2>
        <p>Estos son los artículos que tengo guardados en mi base <strong>ls_shop</strong> con Laravel 💻.</p>

        <!-- ================== BLOQUE DE FILTROS ================== -->
        <!-- Aquí hago un formulario para filtrar por categoría y ordenar -->
        <form method="GET" action="{{ route('home') }}" style="margin-bottom: 20px;">
            <h3>🎯 Filtrar por categoría:</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px;">
                @foreach($categories as $category)
                    @php
                        // Si no hay categorías seleccionadas, marco todas por defecto
                        $checked = empty($selectedCategories) ||
                                   in_array($category->id, (array)$selectedCategories);
                    @endphp

                    <label style="border:1px solid var(--ring); border-radius:15px; padding:6px 10px; cursor:pointer;">
                        <input type="checkbox"
                               name="categories[]"
                               value="{{ $category->id }}"
                               {{ $checked ? 'checked' : '' }}
                               style="margin-right:4px;">
                        {{ $category->nombre }}
                    </label>
                @endforeach
            </div>

            <!-- Ordenación por precio -->
            <h3 style="margin-top: 15px;">💶 Ordenar:</h3>
            <label style="cursor: pointer;">
                <input type="checkbox"
                       name="order_price"
                       value="1"
                       {{ $orderPrice ? 'checked' : '' }}>
                Ordenar por precio (de menor a mayor)
            </label>

            <br>
            <button type="submit"
                    style="margin-top: 10px; padding: 6px 12px; border-radius: 999px;
                           background: var(--accent); color: white; border: none; cursor: pointer;">
                Aplicar filtros
            </button>

            <!-- Enlace para quitar todos los filtros -->
            <a href="{{ route('home') }}"
               style="margin-left: 10px; color: var(--muted); text-decoration: none;">
               Quitar filtros 🔄
            </a>
        </form>

        <!-- ================== TABLA DE PRODUCTOS ================== -->
        <!-- Aquí muestro los productos filtrados desde la BBDD -->
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: color-mix(in srgb, var(--accent) 10%, white);">
                    <th style="padding: 10px; text-align: left;">🛍️ Nombre</th>
                    <th style="padding: 10px; text-align: left;">📂 Categoría</th>
                    <th style="padding: 10px; text-align: right;">💰 Precio</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr style="border-bottom: 1px solid #f2dfe3;">
                        <td style="padding: 8px;">{{ $product->nombre }}</td>
                        <td style="padding: 8px;">
                            {{ optional($product->category)->nombre ?? 'Sin categoría' }}
                        </td>
                        <td style="padding: 8px; text-align: right;">
                            {{ number_format($product->precio, 2, ',', '.') }} €
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 12px;">
                            No hay productos que coincidan con los filtros 😢
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mensajito de resumen -->
        <p style="margin-top: 10px; color: var(--muted); font-size: 14px;">
            📦 Total de productos mostrados: <strong>{{ $products->count() }}</strong>
        </p>
    </div>

    <!-- Fin de la parte nueva -->
@endsection


{{-- 
====================================================================
EXPLICACIÓN DE ESTA VISTA (home.blade.php)
====================================================================

Esta vista es la página principal del proyecto.
Aquí se muestran todos los productos obtenidos desde la base de datos
usando el modelo `Product` y su relación con `Category`.

 Parte visual
----------------------------------------------------
- Mantiene mi diseño alegre con emojis, bordes redondeados y tonos suaves.
- Incluye un bloque de bienvenida con mis frases personalizadas.
- Se añadió una tabla con los productos (nombre, categoría, precio).
- Encima hay filtros por categoría y una opción para ordenar por precio.

 Interacción
----------------------------------------------------
- Los filtros usan checkboxes para seleccionar las categorías.
- El botón "Aplicar filtros" actualiza la tabla según la selección.
- Si no se marca nada, se muestran todos los productos.
- Si se activa "Ordenar por precio", se ordenan de menor a mayor.

 Enlace con el layout
----------------------------------------------------
- Hereda la estructura principal desde `layouts.app.blade.php`
- Usa `@section('title')` para cambiar el título dinámicamente.
- Usa `@section('accent')` para adaptar los colores del tema
  (el layout lo recoge con @yield('accent')).
 
====================================================================
--}}



{{-- 
====================================================================
EXPLICACIÓN/APUNTES (TAREA #4 - ACCESO A LA BASE DE DATOS)
====================================================================

Esta página muestra todos los productos de mi base de datos "ls_shop",
usando el modelo Product (relacionado con Category).

 PASO 1: Creo un formulario de filtros
----------------------------------------------------
- Permite marcar o desmarcar categorías (Informatica, Ropa, Mascotas, Hogar)
- Al enviar, el formulario pasa los datos por GET a la ruta /home
- También hay un checkbox para ordenar por precio

 PASO 2: Muestro la tabla con productos
----------------------------------------------------
- Se muestra el nombre, categoría y precio
- Uso la relación Eloquent "belongsTo" para obtener la categoría
- Si un producto no tiene categoría, aparece “Sin categoría”
- Los precios se muestran con formato 2 decimales y símbolo €

 PASO 3: Interacción
----------------------------------------------------
- Al aplicar filtros, Laravel filtra los productos automáticamente
- Si no hay resultados, aparece un mensaje "no hay productos"
- También se puede pulsar “Quitar filtros” para resetear

 PASO 4: Diseño y estilo
----------------------------------------------------
- Conservo el diseño original de mis tarjetas y emojis 
- Añado colores suaves, bordes redondeados y tipografía legible
- Todo sigue el estilo general de mi plantilla Blade base

====================================================================
--}}
