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
        <h1>📦 Detalles de nuestros productos favoritos</h1>
        <p>
            Explora los artículos más top de <strong>La Tienda de la Nuri</strong> 🌟.
            Aquí enseño algunos ejemplos destacados para que la sección
            no se quede vacía cuando entro solo a <code>/details</code>.
        </p>

        <div class="grid" style="margin-top: 16px;">
            <div class="card">
                <h2>💻 Laptop MSI Modern 14</h2>
                <p>
                    Ligera, rápida y perfecta para clase, trabajo o maratones
                    de series 😅. Es uno de mis productos estrella.
                </p>
            </div>

            <div class="card">
                <h2>🐶 Pienso Premium Perro Adulto</h2>
                <p>
                    Con omega 3 para un pelazo que ni los influencers ✨.
                    Ideal para mimar a las mascotas.
                </p>
            </div>

            <div class="card">
                <h2>💡 Lámpara LED Escritorio</h2>
                <p>
                    3 temperaturas de color para estudiar a gusto sin 
                    quedarte ciega 😎. Perfecta para modo estudiante.
                </p>
            </div>
        </div>

        <p style="margin-top:18px;">
            👉 Si quiero ver la ficha real de un producto (con todos
            los campos y el formulario de edición), tengo que ir a
            <strong>Inicio</strong>, buscarlo en la tabla y pulsar
            <em>"Ver detalles ✏️"</em>. Eso me llevará a 
            <code>/details/{id}</code> donde tengo el CRUD completo.
        </p>
    </div>
@endsection


{{-- 
====================================================================
EXPLICACIÓN / APUNTES (details_index.blade.php)
====================================================================

- Esta vista es solo de presentación, no hace consultas a la base de 
  datos, así que es muy ligera.
- Me sirve para que la ruta /details no de error 404 y además matengo
una pagina bonita para mostrar.
- Mantengo el mismo diseño de tarjetas y emojis que en el resto 
  de la web para que todo se vea coherente.

====================================================================
--}}
