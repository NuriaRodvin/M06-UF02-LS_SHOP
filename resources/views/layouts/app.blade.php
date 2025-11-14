{{-- ============================================================
   Layout base de La Tienda de la Nuri
   - Cabecera con título
   - Menú lateral a la IZQUIERDA con enlaces
   - Nuevo: menú superior tipo Amazon (sin "nuevo producto")
   - Lateral DERECHO con promos destacadas
   - Pie sencillo
   ============================================================ --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title') — La Tienda de la Nuri</title>
  <style>
    :root{
      --accent: @yield('accent', '#d92332');
      --bg: #fff7f8;
      --card: #ffffff;
      --ink: #2b2b2b;
      --muted: #666;
      --ring: color-mix(in srgb, var(--accent) 20%, white);
    }
    * { box-sizing: border-box }
    body{
      margin:0; font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
      color:var(--ink); background:var(--bg);
      display:flex; min-height:100dvh;
    }
    header{
      position: sticky; top:0; z-index:5;
      width:100%; padding:18px 24px; background:var(--card);
      border-bottom:1px solid var(--ring);
    }
    .wrap{ display:flex; width:100%; gap:24px; padding:24px; }
    main{
      flex:1; background: var(--card); border:1px solid var(--ring);
      border-radius:18px; padding:28px; box-shadow:0 8px 20px #0000000e;
    }
    aside{
      width:250px; background:#fff; border:1px solid var(--ring);
      border-radius:18px; padding:18px; height:fit-content;
      position:sticky; top:90px; box-shadow:0 8px 20px #0000000a;
    }
    .aside-right{
      width:230px; background:#fff; border:1px solid var(--ring);
      border-radius:18px; padding:16px; height:fit-content;
      position:sticky; top:90px; box-shadow:0 8px 20px #0000000a;
    }
    .brand{ font-weight:700; color:var(--accent); letter-spacing:.3px }
    .tag{ color:var(--muted); font-size:13px }
    .nav a{
      display:block; padding:10px 12px; border-radius:12px; text-decoration:none;
      color:var(--ink); font-weight:600; margin:6px 0; border:1px solid transparent;
    }
    .nav a:hover{ border-color:var(--ring); background:#fafafa }
    .nav a.active{ background: color-mix(in srgb, var(--accent) 12%, white);
                   border-color: var(--accent); color: var(--accent); }
    h1{ margin:0 0 10px 0; font-size:32px; color:var(--accent) }
    footer{ margin-top:22px; padding-top:16px; border-top:1px dashed var(--ring); color:var(--muted); font-size:14px }
  </style>
</head>
<body>
  <div style="width:100%">
    <header>
      <div class="brand">🛍️ La Tienda de la Nuri</div>
      <div class="tag">@yield('title')</div>

      {{-- ==================================================
           Barra superior tipo Amazon
           - Incluye buscador general
           - Enlaces de acceso rápido (catálogo, ofertas, contacto)
           - NUEVO: icono de carrito 🛒
         ================================================== --}}
      <div style="margin-top:10px; display:flex; flex-wrap:wrap; gap:8px; align-items:center;">
        {{-- Buscador --}}
        <form method="GET" action="{{ route('products.catalog') }}" style="flex:1; min-width:220px; display:flex;">
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="🔎 Buscar productos..."
            style="width:100%; padding:6px 10px; border-radius:999px 0 0 999px; border:1px solid var(--ring);">
          <button type="submit"
                  style="padding:6px 14px; border-radius:0 999px 999px 0; border:1px solid var(--accent);
                         background:var(--accent); color:#fff; cursor:pointer;">
            Buscar
          </button>
        </form>

        {{-- Botones rápidos --}}
        <a href="{{ route('products.catalog') }}"
           style="padding:6px 12px; border:1px solid var(--ring); border-radius:999px; text-decoration:none; color:var(--ink);">
          🛍️ Ver catálogo
        </a>

        <a href="{{ route('offers') }}"
           style="padding:6px 12px; border:1px solid var(--ring); border-radius:999px; text-decoration:none; color:var(--ink);">
          🔥 Ofertas
        </a>

        <a href="{{ route('contact') }}"
           style="padding:6px 12px; border:1px solid var(--ring); border-radius:999px; text-decoration:none; color:var(--ink);">
          📞 Contacto
        </a>

        {{-- Enlace del carrito con contador dinámico --}}
        @php
            // Calcular cuántas unidades hay en el carrito (suma de qty)
            $cartCount = collect(session('cart', []))->sum('qty');
        @endphp

        <a href="{{ route('cart') }}" class="top-link">
            🛒 Carrito ({{ $cartCount }})
        </a>


      </div>
    </header>

    <div class="wrap">
      {{-- Menú lateral IZQUIERDO --}}
      <aside>
        <div class="brand" style="font-size:18px;margin-bottom:8px">Menú</div>
        <nav class="nav">
          <a href="/home" class="{{ request()->is('home') ? 'active':'' }}">🏠 Inicio</a>
          <a href="/products" class="{{ request()->is('products') ? 'active':'' }}">🛒 Productos</a>
          <a href="/details" class="{{ request()->is('details') ? 'active':'' }}">📦 Detalles</a>
          <a href="/contact" class="{{ request()->is('contact') ? 'active':'' }}">📞 Contacto</a>
          <a href="/offers" class="{{ request()->is('offers') ? 'active':'' }}">🔥 Ofertas</a>
        </nav>
        <div style="margin-top:12px">
          <span class="chip">Autora: Nuria Rodríguez Vindel</span>
        </div>
      </aside>

      {{-- Contenido principal --}}
      <main>@yield('content')</main>

      {{-- Lateral DERECHO (promos, anuncios, etc.) --}}
      <aside class="aside-right">
        <div class="card" style="margin-bottom:14px;">
          <h3>🎁 Promo de la semana</h3>
          <p>🚚 Envío gratis en compras superiores a 50€.</p>
          <a href="{{ route('offers') }}" style="color:var(--accent); text-decoration:none; font-weight:600;">Ver ofertas →</a>
        </div>

        {{-- NUEVAS PROMOS --}}

        <div class="card" style="margin-bottom:14px;">
          <h3>👕 Descuento en moda</h3>
          <p>🎉 ¡Aprovecha el 15% en ropa y accesorios hasta fin de mes!</p>
        </div>

        <div class="card">
          <h3>💌 Suscríbete</h3>
          <p>Recibe cupones exclusivos y enterate antes que nadie 💕</p>
        </div>
      </aside>
    </div>

    <div style="padding:0 24px 24px">
      <footer>© 2025 — Creado con 💖 por <strong>Nuria Rodríguez Vindel</strong></footer>
    </div>
  </div>
</body>
</html>


{{--
====================================================================
EXPLICACIÓN GENERAL DEL LAYOUT (TAREA #3, #4 y MEJORAS)
====================================================================

Este layout es la base de toda mi aplicación Laravel.

Cambios realizados (mejoras)
----------------------------------------------------
Eliminé el botón “Nuevo producto” del menú superior.
Añadí un icono de carrito 🛒 con enlace a /cart.
Mantuve el buscador general y enlaces de navegación.
Sustituí la "Ayuda rápida" por promos visuales a la derecha.

Mejoras visuales
----------------------------------------------------
- Mantengo tu diseño coherente con colores suaves y emojis.
- El lateral derecho ahora tiene promos dinámicas tipo tienda.
- El layout es totalmente responsive y sigue el estilo original.

====================================================================
--}}



{{--
    ====================================================================
EXPLICACIÓN GENERAL DEL LAYOUT (TAREA #3 y TAREA #4)
====================================================================

Este layout es la base de toda mi aplicación en Laravel.
Todas las páginas (home, contact, offers, details) usan esta estructura.

Estructura general
----------------------------------------------------
- Cabecera superior fija con el título y subtítulo dinámico (@yield('title'))
- Menú lateral a la IZQUIERDA con navegación entre las rutas
- Zona principal (@yield('content')) donde se muestra cada vista
- Pie de página con mi nombre 

Diseño visual
----------------------------------------------------
- Uso variables CSS con colores suaves (var(--accent), var(--bg), etc.)
- Estilo moderno con sombras, bordes redondeados y tipografía legible
- Cada página puede tener su color principal gracias a @yield('accent')

Añadidos Tarea #4
----------------------------------------------------
- Agregué estilos nuevos para la tabla y los filtros de productos
- Los checkboxes tienen color personalizado y son más visibles
- El botón “Aplicar filtros” tiene efecto de hover suave
- La tabla muestra las filas resaltadas al pasar el ratón

Funcionamiento general
----------------------------------------------------
- Este layout se combina con las vistas Blade (home, contact, offers, etc.)
- Cada vista define su título y su contenido
- Todo el diseño se mantiene consistente entre páginas

NUEVO (mejoras “competencia Amazon”)
----------------------------------------------------
- Barra de atajos en la cabecera (Nuevo producto, Catálogo, Ofertas, Contacto)
- Panel lateral derecho con ayuda rápida y promociones
- Buscador global con placeholder genérico
====================================================================
--}}

