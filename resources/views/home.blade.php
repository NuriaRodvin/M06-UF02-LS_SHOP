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
        BLOQUE NUEVO: ENLACE AL CATÁLOGO “TIPO AMAZON”
        - Esta parte hace de puente entre la portada y /products
        - /products es mi competencia de Amazon con tarjetas, filtros,
          buscador y paginación (se ve más “real tienda online”).
        - Aquí NO hago CRUD, solo mando a la otra vista.
    ======================================================== -->
    <div class="card" style="margin-top: 24px;">
        <h2>🛒 Explora el catálogo completo</h2>
        <p>
            Si quieres ver todos los productos con fotos, precio grande y botones
            , puedes entrar al catálogo completo.
        </p>

        {{-- Mini-grid de categorías que llevan a /products con filtros --}}
<!-- ================================
     MINI-GRID DE CATEGORÍAS CON HOVER Y RECUADRO
     --------------------------------
     Recupera el formato original tipo Amazon:
     - Tarjetas horizontales con borde y sombra
     - Hover suave con borde de color principal
================================ -->
<div class="grid"
     style="margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;">

    @foreach($categories as $category)
        <div class="card"
             style="border-radius:16px;
                    padding:18px;
                    background:#fff;
                    border:1px solid var(--ring);
                    box-shadow:0 3px 10px #00000010;
                    transition: all 0.25s ease;
                    cursor:pointer;"
             onmouseover="this.style.borderColor='var(--accent)'; this.style.boxShadow='0 6px 16px #00000025';"
             onmouseout="this.style.borderColor='var(--ring)'; this.style.boxShadow='0 3px 10px #00000010';">

            <h3 style="margin-top:0; color:var(--accent); font-size:18px;">
                🛍️ {{ $category->nombre }}
            </h3>

            <p style="font-size:14px; color:var(--muted); margin-bottom:10px;">
                Ver solo los productos de <strong>{{ $category->nombre }}</strong> 
                en modo catálogo tipo Amazon.
            </p>

            <a href="{{ route('products.catalog', ['category_id' => $category->id]) }}"
               style="display:inline-block; margin-top:auto; padding:8px 14px;
                      border-radius:999px; background:var(--accent); color:#fff;
                      text-decoration:none; font-size:13px; transition:all .2s ease;"
               onmouseover="this.style.background='color-mix(in srgb, var(--accent) 85%, white)';"
               onmouseout="this.style.background='var(--accent)';">
                Ver {{ $category->nombre }} ➜
            </a>
        </div>
    @endforeach
</div>


        {{-- Botón grande para ver TODO el catálogo --}}
        <div style="margin-top: 14px;">
            <a href="{{ route('products.catalog') }}"
               style="padding:8px 16px; border-radius:999px; background:var(--accent);
                      color:#fff; text-decoration:none; font-weight:600;">
                Ver todos los productos 🚀
            </a>
        </div>
    </div>



    {{-- *****************************************************************
       A PARTIR DE AQUÍ TENGO LA VERSIÓN “CLÁSICA” DE LA TAREA #4
       --------------------------------------------------------------
       - Es la tabla con filtros y ordenación en la propia página home.
       - Ahora mismo quiero que la portada sea más sencilla y que el
         catálogo “potente” viva en /products.
       - Como NO quiero perder el código (para mis apuntes), 
       simplemente lo desactivo visualmente con
         @if(false) ... @endif. Así Laravel no lo pinta, pero yo sigo
         teniendo todo el trabajo hecho en este archivo.
       ***************************************************************** --}}
    @if(false)
    <!-- =======================================================
        A PARTIR DE AQUÍ EMPIEZA LA PARTE DE LA TAREA #4
        - Mostrar productos reales desde la base de datos (ls_shop)
        - Permitir filtrar por categoría
        - Permitir ordenar por precio
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
                    <th style="padding: 10px; text-align: center;">⚙️ Acciones</th>
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
                        <td style="padding: 8px; text-align: center;">
                            {{-- Enlace a detalles pasando también los filtros actuales --}}
                            <a href="{{ route('details', [
                                    'id'          => $product->id,
                                    'categories'  => $selectedCategories,
                                    'order_price' => $orderPrice ? 1 : 0,
                                ]) }}"
                               style="padding:6px 10px; border-radius:999px; border:1px solid var(--accent);
                                      text-decoration:none; color:var(--accent); font-size:13px;">
                                Ver detalles ✏️
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 12px;">
                            No hay productos que coincidan con los filtros 😢
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Botón para ir al formulario de nuevo producto -->
        <div style="margin-top: 15px;">
            <a href="{{ route('products.create', [
                    'categories'  => $selectedCategories,
                    'order_price' => $orderPrice ? 1 : 0,
                ]) }}"
               style="padding:8px 14px; border-radius:999px; background:var(--accent);
                      color:#fff; text-decoration:none; font-size:14px;">
                ➕ Añadir nuevo producto
            </a>
        </div>

        <!-- Mensajito de resumen -->
        <p style="margin-top: 10px; color: var(--muted); font-size: 14px;">
            📦 Total de productos mostrados: <strong>{{ $products->count() }}</strong>
        </p>
    </div>

    <!-- Fin de la parte nueva -->
    @endif
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

 Nota como alumna novata 
----------------------------------------------------
- Ahora la tabla de la Tarea #4 está dentro de un @if(false),
  porque el catálogo principal lo hago en /products con tarjetas.
- Así no “ensucio” la portada, pero sigo teniendo mi código de la
  práctica guardado y funcionando si algún día quito el @if(false).

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


PASO 5: Configuración de la base de datos de archivo .env
---------------------------------------------------------
- Modifico para que sea XAMPP y no SQLite
  (DB_CONNECTION=mysql + DB_DATABASE=ls_shop + DB_USERNAME=root + DB_PASSWORD=  )
- También he modificado para que el cache sea un archivo y no la base de datos
  (CACHE_STORE=file  + SESSION_DRIVER=file + QUEUE_CONNECTION=sync)

 Nota extra como apuntes:
---------------------------------------------------------
- Aunque ahora el catálogo bonito vive en /products, esta página
  me sirve como “laboratorio” para entender filtros, orderBy,
  relaciones Eloquent y formularios GET en Laravel.
- Me dejo todos estos comentarios porque todavía soy novata
  y así, cuando repase para el examen, entenderé qué hice 

====================================================================
--}} 
