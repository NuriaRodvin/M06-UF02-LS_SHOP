@extends('layouts.app')

{{-- Puedo dejar el accent por defecto o darle uno distinto a detalles --}}
@section('accent', '#f25d27')

@section('title', 'Detalles del producto')

@section('content')
    <!-- =======================================================
        VISTA DE DETALLES / CRUD DEL PRODUCTO
        Aquí puedo:
        - Ver todos los campos del producto
        - Editarlos (UPDATE)
        - Borrarlo (DELETE)
        Mantengo los filtros que venían de /home.
    ======================================================== -->

    <h1>📦 Detalles de: <strong>{{ $product->nombre }}</strong></h1>

    {{-- Mensaje de éxito si vengo de un update o delete --}}
    @if (session('status'))
        <div class="card" style="margin-bottom: 15px; border-left:4px solid var(--accent);">
            {{ session('status') }}
        </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="card" style="margin-bottom: 15px; border-left:4px solid #d9534f;">
            <strong>⚠️ Hay errores en el formulario:</strong>
            <ul style="margin-top: 8px;">
                @foreach ($errors->all() as $error)
                    <li>👉 {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <h2>✏️ Editar producto</h2>
        <p>Puedo cambiar cualquiera de estos campos y guardar los cambios.</p>

        <form method="POST" action="{{ route('details.update', ['id' => $product->id]) }}">
            @csrf
            @method('PUT')

            {{-- Mantengo los filtros como inputs ocultos para que no se pierdan --}}
            @foreach((array)$selectedCategories as $catId)
                <input type="hidden" name="categories[]" value="{{ $catId }}">
            @endforeach
            <input type="hidden" name="order_price" value="{{ $orderPrice ? 1 : 0 }}">

            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="padding:8px; width:160px;"><strong>Nombre</strong></td>
                    <td style="padding:8px;">
                        <input type="text" name="nombre" value="{{ old('nombre', $product->nombre) }}"
                               style="width:100%; padding:6px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px;"><strong>Categoría</strong></td>
                    <td style="padding:8px;">
                        <select name="category_id" style="width:100%; padding:6px;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px;"><strong>Precio (€)</strong></td>
                    <td style="padding:8px;">
                        <input type="number" step="0.01" name="precio"
                               value="{{ old('precio', $product->precio) }}"
                               style="width:100%; padding:6px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px;"><strong>Stock</strong></td>
                    <td style="padding:8px;">
                        <input type="number" name="stock"
                               value="{{ old('stock', $product->stock) }}"
                               style="width:100%; padding:6px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px;"><strong>SKU</strong></td>
                    <td style="padding:8px;">
                        <input type="text" name="sku"
                               value="{{ old('sku', $product->sku) }}"
                               style="width:100%; padding:6px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px;"><strong>Activo</strong></td>
                    <td style="padding:8px;">
                        <select name="activo" style="width:100%; padding:6px;">
                            <option value="1" {{ old('activo', $product->activo) == 1 ? 'selected' : '' }}>Visible</option>
                            <option value="0" {{ old('activo', $product->activo) == 0 ? 'selected' : '' }}>Oculto</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px;"><strong>Descripción</strong></td>
                    <td style="padding:8px;">
                        <textarea name="descripcion" rows="4" style="width:100%; padding:6px;">{{ old('descripcion', $product->descripcion) }}</textarea>
                    </td>
                </tr>
            </table>

            <button type="submit"
                    style="margin-top:12px; padding:8px 14px; border-radius:999px;
                           background:var(--accent); color:#fff; border:none; cursor:pointer;">
                💾 Guardar cambios
            </button>
        </form>
    </div>

    <div class="card" style="margin-top:20px;">
        <h2>🗑️ Borrar producto</h2>
        <p>Si borro este producto, desaparecerá de la tienda.</p>

        <form method="POST" action="{{ route('details.delete', ['id' => $product->id]) }}"
              onsubmit="return confirm('¿Seguro que quieres borrar este producto? 😱');">
            @csrf
            @method('DELETE')

            {{-- También llevo los filtros de vuelta --}}
            @foreach((array)$selectedCategories as $catId)
                <input type="hidden" name="categories[]" value="{{ $catId }}">
            @endforeach
            <input type="hidden" name="order_price" value="{{ $orderPrice ? 1 : 0 }}">

            <button type="submit"
                    style="padding:8px 14px; border-radius:999px; background:#d9534f;
                           color:#fff; border:none; cursor:pointer;">
                Eliminar producto
            </button>
        </form>
    </div>

    {{-- Botón para volver a home con los filtros que tenía --}}
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
