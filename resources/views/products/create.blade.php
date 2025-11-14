{{-- ============================================================
   VISTA: resources/views/products/create.blade.php
   ------------------------------------------------------------
   Aquí tengo el formulario para INSERTAR un nuevo producto
   en mi tabla "products" de la base de datos ls_shop.

   Esta vista:
     - Usa mi layout principal (layouts.app)
     - Muestra un formulario con todos los campos del producto
     - Envía los datos al controlador mediante POST (ruta products.store)
     - Mantiene los filtros de la home para poder volver luego
   ============================================================ --}}

@extends('layouts.app')

{{-- Título que se verá en la cabecera y en el <title> del layout --}}
@section('title', 'Nuevo producto')

@section('content')
    <!-- =======================================================
        CABECERA DE LA PÁGINA
        Aquí simplemente doy la bienvenida al formulario de
        creación de productos.
    ======================================================== -->
    <h1>➕ Crear nuevo producto</h1>
    <p>
        Aquí puedo añadir un nuevo artículo a
        <strong>La Tienda de la Nuri</strong> 🛍️.
        Todo lo que escriba en este formulario se guardará en la
        tabla <code>products</code> de mi base de datos <strong>ls_shop</strong>.
    </p>

    {{-- ==========================================================
        BLOQUE DE ERRORES DE VALIDACIÓN
        ----------------------------------------------------------
        Si en el controlador he puesto reglas de validación
        (por ejemplo: nombre obligatorio, precio numérico, etc.)
        y el usuario se equivoca, aquí se mostrarán los errores.

        $errors->any()  -> comprueba si hay algún error.
        $errors->all()  -> devuelve un array con todos los mensajes.
    =========================================================== --}}
    @if ($errors->any())
        <div class="card"
             style="margin-bottom: 15px; border-left:4px solid #d9534f;">
            <strong>⚠️ Hay errores en el formulario:</strong>
            <ul style="margin-top: 8px;">
                @foreach ($errors->all() as $error)
                    <li>👉 {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ==========================================================
        TARJETA PRINCIPAL CON EL FORMULARIO
        ----------------------------------------------------------
        Uso una "card" para que el formulario no quede pegado
        al fondo. Dentro meto una tabla para alinear bien
        etiquetas y campos. No es obligatorio usar tablas,
        pero a mí me resulta más sencillo por ahora.
    =========================================================== --}}
    <div class="card">
        {{-- 
            FORMULARIO DE INSERCIÓN
            -----------------------
            method="POST" -> porque voy a crear un recurso nuevo.
            action="products.store" -> ruta que apuntará al método
            store() de mi controlador, donde haré:
               - Validación
               - Insert del Product
               - Redirección de vuelta (seguramente a home o details)
        --}}
        <form method="POST" action="{{ route('products.store') }}">
            {{-- Token CSRF obligatorio en Laravel para formularios POST --}}
            @csrf

            {{-- ======================================================
                MANTENER LOS FILTROS CUANDO VENGO DESDE HOME
                ------------------------------------------------------
                Si entro a este formulario desde la página principal,
                ahí tengo filtros por categoría y ordenación por precio.

                Para que al volver no se pierdan, guardo aquí los
                mismos valores en campos ocultos (hidden).

                Más tarde, en el controlador, los puedo leer y volver
                a pasarlos a la vista de la home.
            ======================================================= --}}
            @foreach((array)$selectedCategories as $catId)
                <input type="hidden" name="categories[]" value="{{ $catId }}">
            @endforeach
            <input type="hidden" name="order_price" value="{{ $orderPrice ? 1 : 0 }}">

            {{-- ======================================================
                TABLA CON LOS CAMPOS DEL PRODUCTO
                ------------------------------------------------------
                Cada fila de la tabla contiene:
                  - En la primera columna: el nombre del campo (texto)
                  - En la segunda columna: el input correspondiente

                Uso old('campo') para que, si hay errores y Laravel
                devuelve la página, se mantengan los valores que el
                usuario ya había escrito (muy útil para no perder datos).
            ======================================================= --}}
            <table style="width:100%; border-collapse:collapse;">
                {{-- Campo: nombre --}}
                <tr>
                    <td style="padding:8px; width:160px;">
                        <strong>Nombre</strong>
                    </td>
                    <td style="padding:8px;">
                        <input
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            style="width:100%; padding:6px;"
                            placeholder="Ej: Laptop MSI Modern 14">
                    </td>
                </tr>

                {{-- Campo: categoría (select con opciones) --}}
                <tr>
                    <td style="padding:8px;">
                        <strong>Categoría</strong>
                    </td>
                    <td style="padding:8px;">
                        <select name="category_id" style="width:100%; padding:6px;">
                            <option value="">-- Selecciona categoría --</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                {{-- Campo: precio --}}
                <tr>
                    <td style="padding:8px;">
                        <strong>Precio (€)</strong>
                    </td>
                    <td style="padding:8px;">
                        <input
                            type="number"
                            step="0.01"    {{-- Permite decimales como 39.99 --}}
                            name="precio"
                            value="{{ old('precio') }}"
                            style="width:100%; padding:6px;"
                            placeholder="Ej: 39.90">
                    </td>
                </tr>

                {{-- Campo: stock --}}
                <tr>
                    <td style="padding:8px;">
                        <strong>Stock</strong>
                    </td>
                    <td style="padding:8px;">
                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', 0) }}" {{-- por defecto 0 --}}
                            style="width:100%; padding:6px;"
                            placeholder="Unidades disponibles">
                    </td>
                </tr>

                {{-- Campo: SKU (código interno) --}}
                <tr>
                    <td style="padding:8px;">
                        <strong>SKU</strong>
                    </td>
                    <td style="padding:8px;">
                        <input
                            type="text"
                            name="sku"
                            value="{{ old('sku') }}"
                            style="width:100%; padding:6px;"
                            placeholder="Ej: INF-MSI-14-PRM">
                    </td>
                </tr>

                {{-- Campo: activo (visible u oculto) --}}
                <tr>
                    <td style="padding:8px;">
                        <strong>Activo</strong>
                    </td>
                    <td style="padding:8px;">
                        <select name="activo" style="width:100%; padding:6px;">
                            {{-- Por defecto dejo "Visible" seleccionado --}}
                            <option value="1" {{ old('activo', 1) == 1 ? 'selected' : '' }}>
                                Visible (se verá en la tienda)
                            </option>
                            <option value="0" {{ old('activo', 1) == 0 ? 'selected' : '' }}>
                                Oculto (no se mostrará)
                            </option>
                        </select>
                    </td>
                </tr>

                {{-- Campo: descripción (textarea) --}}
                <tr>
                    <td style="padding:8px;">
                        <strong>Descripción</strong>
                    </td>
                    <td style="padding:8px;">
                        <textarea
                            name="descripcion"
                            rows="4"
                            style="width:100%; padding:6px;"
                            placeholder="Descripción bonita del producto...">
                            {{ old('descripcion') }}
                        </textarea>
                    </td>
                </tr>
            </table>

            {{-- ======================================================
                BOTÓN DE ENVÍO
                ------------------------------------------------------
                Cuando el usuario pulse este botón:
                  - Se enviará todo el formulario al método store()
                  - Laravel validará los datos
                  - Si todo está bien -> insertará el nuevo Product
                  - Si algo falla -> volverá aquí con errores y old()
            ======================================================= --}}
            <button
                type="submit"
                style="margin-top:12px; padding:8px 14px; border-radius:999px;
                       background:var(--accent); color:#fff; border:none; cursor:pointer;">
                💾 Guardar producto
            </button>
        </form>
    </div>

    {{-- ==========================================================
        ENLACE PARA VOLVER A LA HOME
        ----------------------------------------------------------
        Importante: aquí vuelvo a enviar los filtros que tenía
        en la página principal (categorías y ordenación). De esta
        forma, cuando regrese a /home, veré la tabla tal y como
        estaba antes de venir a crear el producto.
    =========================================================== --}}
    <p style="margin-top:15px;">
        <a href="{{ route('home', [
                'categories'  => $selectedCategories,
                'order_price' => $orderPrice ? 1 : 0,
            ]) }}"
           style="text-decoration:none; color:var(--accent);">
            ⬅ Volver al listado de productos
        </a>
    </p>
@endsection


{{--
====================================================================
 EXPLICACIÓN/RESUMEN DE ESTA VISTA (create.blade.php)
====================================================================

- Esta página pertenece a la Tarea #5 (CRUD), concretamente a la
  parte de INSERT (Create). Desde aquí el usuario puede añadir
  un nuevo producto a la tabla "products".

- La vista extiende del layout principal (layouts.app) para
  mantener el mismo diseño, menú lateral y pie de página.

- El formulario usa:
      method="POST"
      action="{{ route('products.store') }}"
  lo que significa que en web.php tengo una ruta llamada
  "products.store" que apunta a un método store() del controlador,
  donde haré realmente la inserción en la base de datos.

- Se usan helpers de Blade como:
      @csrf           -> seguridad para formularios
      old('campo')    -> recuperar valores tras un error
      $errors->any()  -> comprobar si existen errores
      $errors->all()  -> listarlos todos

- También paso a través de inputs ocultos los valores de los
  filtros que tenía en la página "home" (categories y order_price)
  para que al volver pueda reconstruir el mismo estado.

Con todo esto, cumplo la parte de:
Funcionalidad "Insert"
Control de errores básico
Envío de información entre vistas (filtros)

====================================================================
--}}
