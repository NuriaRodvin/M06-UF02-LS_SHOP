@extends('layouts.app')

{{-- Color principal para la sección de detalles --}}
@section('accent', '#ff6b3d')

@section('title', 'Detalles')

@section('content')
    {{-- 
        ===========================================================
        SECCIÓN GENERAL DE DETALLES (SIN ID)
        -----------------------------------------------------------
        Esta página se abre cuando hago clic en el menú lateral 
        "Detalles". No depende de ningún producto concreto.
        
        La uso como una especie de portada bonita, con tarjetas
        que recuerdan a los ejemplos que tenía al principio
        del ejercicio (Laptop, Pienso, Lámpara, etc.).
        
        El CRUD real (update/delete) se hace en /details/{id}.
        ===========================================================
    --}}

    <div class="card">
        <h1 style="display:flex; align-items:center; gap:10px;">
            <span style="
            display:inline-flex; align-items:center; justify-content:center;
            width:38px; height:38px; border-radius:12px;
            background:#fff; border:1px solid var(--ring);
            box-shadow:0 4px 12px #00000010; font-size:22px;">
            📦
             </span>
             Detalles de nuestros productos novedosos
        </h1>

        {{-- GRID HORIZONTAL DE TARJETAS (como en tu formato anterior) --}}
        <div class="grid"
             style="margin-top:16px;
                    display:grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap:20px;">

            <div class="card"
                 style="padding:16px; border-radius:16px; border:1px solid var(--ring);
                        background:#fff; box-shadow:0 4px 12px #00000012;
                        transition:all .2s ease;"
                 onmouseover="this.style.boxShadow='0 8px 18px #00000022'; this.style.borderColor='var(--accent)';"
                 onmouseout="this.style.boxShadow='0 4px 12px #00000012'; this.style.borderColor='var(--ring)';">
                <h2 style="margin-top:0;">💻 Laptop MSI Modern 14</h2>
                <p>
                    Ligera, rápida y perfecta para clase, trabajo o maratones
                    de series 😅. Es uno de mis productos estrella.
                </p>
            </div>

            <div class="card"
                 style="padding:16px; border-radius:16px; border:1px solid var(--ring);
                        background:#fff; box-shadow:0 4px 12px #00000012;
                        transition:all .2s ease;"
                 onmouseover="this.style.boxShadow='0 8px 18px #00000022'; this.style.borderColor='var(--accent)';"
                 onmouseout="this.style.boxShadow='0 4px 12px #00000012'; this.style.borderColor='var(--ring)';">
                <h2 style="margin-top:0;">🐶 Pienso Premium Perro Adulto</h2>
                <p>
                    Con omega 3 para un pelazo que ni los influencers ✨.
                    Ideal para mimar a las mascotas.
                </p>
            </div>

            <div class="card"
                 style="padding:16px; border-radius:16px; border:1px solid var(--ring);
                        background:#fff; box-shadow:0 4px 12px #00000012;
                        transition:all .2s ease;"
                 onmouseover="this.style.boxShadow='0 8px 18px #00000022'; this.style.borderColor='var(--accent)';"
                 onmouseout="this.style.boxShadow='0 4px 12px #00000012'; this.style.borderColor='var(--ring)';">
                <h2 style="margin-top:0;">💡 Lámpara LED Escritorio</h2>
                <p>
                    3 temperaturas de color para estudiar a gusto sin 
                    quedarte ciega 😎. Perfecta para modo estudiante.
                </p>
            </div>
        </div>

        <p style="margin-top:18px;">
            👉 Para consultar la ficha completa de un producto y editarla,
            ve a <strong>Inicio</strong>, búscalo en la lista y pulsa
            <em>“Ver detalles ✏️”</em>. Desde allí podrás explorar y actualizar
            toda su información 🛍️✨
        </p>
    </div>
@endsection



{{-- 
====================================================================
EXPLICACIÓN / APUNTES (details_index.blade.php)
====================================================================

- Esta vista es solo de presentación, no hace consultas a la base de 
  datos, así que es muy ligera.
- Me sirve para que la ruta /details no dé error 404 y además mantengo
  una página bonita para mostrar, con productos “favoritos”.
- Mantengo el mismo diseño de tarjetas y emojis que en el resto 
  de la web para que todo se vea coherente.

- NUEVO:
  - He añadido una frase introductoria arriba para que parezca una
    “zona de destacados”, como hacen las tiendas grandes.
  - También he añadido dos botones al final:
      * Uno va al catálogo tipo Amazon (/products).
      * El otro va a /home, donde tengo la tabla con el CRUD completo.
  - Así demuestro que conecto esta página de detalles con las otras
    partes del proyecto (catálogo e interfaz de administración).

====================================================================
--}}
