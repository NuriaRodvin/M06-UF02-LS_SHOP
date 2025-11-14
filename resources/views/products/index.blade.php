@extends('layouts.app')

{{-- Color principal para esta página (un naranja tipo “catálogo”) --}}
@section('accent', '#ff9900')

{{-- IMPORTANTE: vacío el subtítulo bajo la cabecera para no mostrar “modo Amazon” --}}
@section('title', '')

@section('content')
    {{-- ===========================================================
        CATÁLOGO DE PRODUCTOS
        -----------------------------------------------------------
        Esta página NO es la tabla de la Tarea 4 (esa estaba en /home).
        Aquí muestro los productos como tarjetas.
        Puedo buscar (q), filtrar por UNA categoría y ordenar por precio.
        El CRUD real lo abro con “Ver detalles” (details/{id}).
        Controlador: PageController@productsCatalog  Ruta: GET /products
    ============================================================ --}}

    <h1>🛒 Catálogo de productos de La Tienda de la Nuri</h1>
    <p class="lead">
        Bienvenida al catálogo visual. Aquí ves los productos como tarjetas, con imagen, precio y categoría 🤩.
    </p>

    {{-- ====== FILTROS RÁPIDOS (BUSCADOR + CATEGORÍA + ORDEN) ====== --}}
    <div class="card" style="margin-bottom:20px;">
        <form method="GET" action="{{ route('products.catalog') }}"
              style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end;">

            {{-- Buscador por nombre (reutilizo el mismo parámetro q que en el layout) --}}
            <div style="flex:2; min-width:220px;">
                <label for="q"><strong>🔎 Buscar producto</strong></label>
                <input type="text" id="q" name="q"
                       value="{{ $search }}"
                       placeholder="Escribe por ejemplo: laptop, perro, lámpara..."
                       style="width:100%; padding:6px;">
            </div>

            {{-- Filtro por categoría única --}}
            <div style="flex:1; min-width:180px;">
                <label for="category_id"><strong>📂 Categoría</strong></label>
                <select id="category_id" name="category_id" style="width:100%; padding:6px;">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                                {{ (int)$categoryId === $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ordenación por precio --}}
            <div style="flex:1; min-width:160px;">
                <label><strong>💶 Ordenar</strong></label><br>
                <label style="font-size:14px; cursor:pointer;">
                    <input type="checkbox" name="order_price" value="1"
                           {{ $orderPrice ? 'checked' : '' }}>
                    Precio de menor a mayor
                </label>
            </div>

            <div style="flex:0;">
                <button type="submit"
                        style="padding:8px 14px; border-radius:999px;
                               background:var(--accent); color:#fff; border:none; cursor:pointer;">
                    Aplicar filtros
                </button>
            </div>
        </form>
    </div>

{{-- ==========================================================
     GRID DE PRODUCTOS TIPO AMAZON (CON HOVER)
     ----------------------------------------------------------
     - Tarjetas horizontales con borde redondeado y sombra.
     - Efecto hover que resalta el producto.
     - Diseño flexible: se adapta al ancho del dispositivo.
=========================================================== --}}
@if ($products->count() === 0)
    <div class="card">
        No se han encontrado productos con estos filtros 😢. Prueba otra búsqueda.
    </div>
@else
    <div class="grid"
         style="display:grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap:20px; margin-top:16px;">

        @foreach($products as $product)
            <div class="card"
                 style="border-radius:16px;
                        background:#fff;
                        border:1px solid var(--ring);
                        box-shadow:0 3px 10px #00000010;
                        padding:16px;
                        transition: all 0.25s ease;
                        cursor:pointer;
                        display:flex; 
                        flex-direction:column; 
                        justify-content:space-between; height:100%;"
                 onmouseover="this.style.borderColor='var(--accent)'; this.style.boxShadow='0 6px 16px #00000025';"
                 onmouseout="this.style.borderColor='var(--ring)'; this.style.boxShadow='0 3px 10px #00000010';">

                {{-- Imagen del producto si existe --}}
                @if($product->imagen ?? false)
                    <img src="{{ asset('storage/'.$product->imagen) }}" 
                         alt="{{ $product->nombre }}" 
                         style="width:100%; height:140px; object-fit:cover; border-radius:12px; margin-bottom:10px;">
                @else
                    <div style="width:100%; height:140px; display:flex; align-items:center; justify-content:center;
                                background:color-mix(in srgb, var(--accent) 10%, white); border-radius:12px; font-size:38px;">
                        📦
                    </div>
                @endif

                {{-- Nombre del producto --}}
                <h3 style="margin:0; color:var(--accent); font-size:17px;">
                    {{ $product->nombre }}
                </h3>

                {{-- Categoría --}}
                <p style="font-size:14px; color:var(--muted); margin:6px 0 4px 0;">
                    📂 {{ optional($product->category)->nombre ?? 'Sin categoría' }}
                </p>

                {{-- Descripción breve (limitada) --}}
                <p style="font-size:13px; color:#555; flex-grow:1;">
                    {{ \Illuminate\Support\Str::limit($product->descripcion, 80) }}
                </p>

                {{-- Precio --}}
                <p style="font-size:16px; font-weight:bold; color:#333; margin:8px 0;">
                    💰 {{ number_format($product->precio, 2, ',', '.') }} €
                </p>

                {{-- BOTONES: VER DETALLES + AÑADIR AL CARRITO --}}
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="{{ route('details', ['id' => $product->id]) }}"
                       style="flex:1; text-align:center; padding:8px 14px;
                              border-radius:999px; background:var(--accent); color:#fff;
                              text-decoration:none; font-size:13px; transition:all .2s ease;"
                       onmouseover="this.style.background='color-mix(in srgb, var(--accent) 85%, white)';"
                       onmouseout="this.style.background='var(--accent)';">
                        Ver detalles ✏️
                    </a>

                    <form method="POST" action="{{ route('cart.add', $product->id) }}" style="flex:1;">
                        @csrf
                        <input type="hidden" name="qty" value="1">
                        <button type="submit"
                                style="width:100%; padding:8px 14px; border-radius:999px;
                                       background:var(--accent); border:none; color:#fff;
                                       font-size:13px; cursor:pointer; transition:all .2s ease;"
                                onmouseover="this.style.background='color-mix(in srgb, var(--accent) 85%, white)';"
                                onmouseout="this.style.background='var(--accent)';">
                            Añadir al carrito 🛒
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>


    {{-- Paginación abajo (personalizada) --}}
    <div style="margin-top:20px; text-align:center; font-size:14px;">
        @if ($products->hasPages())
            <div style="
                display:inline-flex;
                align-items:center;
                gap:18px;
                padding:8px 18px;
                border-radius:999px;
                background:color-mix(in srgb, var(--accent) 8%, #fff);
                border:1px solid color-mix(in srgb, var(--accent) 30%, #fff);
            ">
                {{-- Anterior --}}
                @if ($products->onFirstPage())
                    <span style="opacity:.4;">⏪ Anterior</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                    style="text-decoration:none; color:var(--accent);">
                        ⏪ Anterior
                    </a>
                @endif

                {{-- Texto central --}}
                <span style="color:#444;">
                    Página <strong>{{ $products->currentPage() }}</strong>
                    de <strong>{{ $products->lastPage() }}</strong>
                </span>

                {{-- Siguiente --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                    style="text-decoration:none; color:var(--accent);">
                        Siguiente ⏩
                    </a>
                @else
                    <span style="opacity:.4;">Siguiente ⏩</span>
                @endif
            </div>

            <div style="margin-top:6px; color:var(--muted);">
                Mostrando {{ $products->firstItem() }} a {{ $products->lastItem() }}
                de {{ $products->total() }} resultados
            </div>
        @endif
    </div>

@endif

    <p style="margin-top:10px; color:var(--muted); font-size:14px;">
        📦 Total de productos en esta página: <strong>{{ $products->count() }}</strong>
        (de {{ $products->total() }} resultados).
    </p>
@endsection



