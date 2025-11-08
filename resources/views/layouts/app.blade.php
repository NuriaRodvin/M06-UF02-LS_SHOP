{{-- ============================================================
   Layout base de La Tienda de la Nuri
   - Cabecera con título
   - Menú lateral a la IZQUIERDA con enlaces
   - Pie sencillo
   - Sistema de “accent color” por página con CSS variables
   ============================================================ --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title') — La Tienda de la Nuri</title>
  <style>
    :root{
      --accent: @yield('accent', '#d92332');         /* color por página */
      --bg: #fff7f8;                                 /* fondo suave */
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
    h2{ margin:18px 0 8px; color:#222 }
    .lead{ font-size:17px; color:var(--muted) }
    .card{
      border:1px solid var(--ring); border-radius:16px; padding:18px; background:#fff;
      box-shadow:0 8px 20px #0000000a;
    }
    .grid{ display:grid; gap:16px; grid-template-columns: repeat( auto-fit, minmax(220px, 1fr) ); }
    .list li{ margin:10px 0 }
    footer{ margin-top:22px; padding-top:16px; border-top:1px dashed var(--ring); color:var(--muted); font-size:14px }
    /* chips */
    .chip{
      display:inline-block; padding:4px 10px; border-radius:999px;
      border:1px solid var(--ring); background:#fff; font-size:12px; color:var(--muted)
    }

    /* ======================================================
       🌸 ESTILOS EXTRA TAREA #4 (Filtros + Tabla de productos)
       ====================================================== */

    /* Checkbox y chips del formulario */
    form label input[type="checkbox"] {
      accent-color: var(--accent);
      transform: scale(1.2);
      vertical-align: middle;
    }

    /* Títulos de filtros */
    form h3 {
      margin-bottom: 4px;
      color: var(--accent);
      font-size: 16px;
    }

    /* Botón de aplicar filtros */
    button[type="submit"] {
      transition: background 0.3s, transform 0.2s;
    }
    button[type="submit"]:hover {
      background: color-mix(in srgb, var(--accent) 90%, black 5%);
      transform: scale(1.03);
    }

    /* Tabla de productos */
    table {
      border-radius: 10px;
      overflow: hidden;
      font-size: 15px;
    }
    table th {
      color: var(--accent);
      font-weight: 600;
    }
    table tr:hover {
      background: #fff6f7;
      transition: background 0.2s;
    }
    table td {
      vertical-align: middle;
    }

    /* Total de productos */
    p[style*="Total de productos"] strong {
      color: var(--accent);
    }
  </style>
</head>
<body>
  <div style="width:100%">
    <header>
      <div class="brand">🛍️ La Tienda de la Nuri</div>
      <div class="tag">@yield('title')</div>
    </header>

    <div class="wrap">
      {{-- Menú lateral a la IZQUIERDA --}}
      <aside>
        <div class="brand" style="font-size:18px;margin-bottom:8px">Menú</div>
        <nav class="nav">
          <a href="/home"    class="{{ request()->is('home')    ? 'active':'' }}">🏠 Inicio</a>
          <a href="/details" class="{{ request()->is('details') ? 'active':'' }}">📦 Detalles</a>
          <a href="/contact" class="{{ request()->is('contact') ? 'active':'' }}">📞 Contacto</a>
          <a href="/offers"  class="{{ request()->is('offers')  ? 'active':'' }}">🔥 Ofertas</a>
        </nav>
        <div style="margin-top:12px">
          <span class="chip">Autora: Nuria Rodríguez Vindel</span>
        </div>
      </aside>

      <main>@yield('content')</main>
    </div>
    <div style="padding:0 24px 24px">
      <footer>© 2025 — Creado con 💖 por <strong>Nuria Rodríguez Vindel</strong></footer>
    </div>
  </div>
</body>
</html>

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

====================================================================
--}}





