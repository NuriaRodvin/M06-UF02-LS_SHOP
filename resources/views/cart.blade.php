@extends('layouts.app')

{{-- Color principal para esta página (naranja catálogo) --}}
@section('accent', '#ff9900')
@section('title', 'Carrito')

@section('content')
    <h1>🛒 Tu carrito</h1>

    @if (session('ok'))
        <div class="card" style="margin-bottom:12px; border-left:4px solid var(--accent);">
            {{ session('ok') }}
        </div>
    @endif

    @if (empty($cart))
        <div class="card">
            Aún no has añadido productos al carrito. ¡Vuelve al catálogo y elige algo bonito! ✨
        </div>
    @else
        <div class="card">
            {{-- Lista de líneas del carrito --}}
            <div class="grid" style="display:grid; grid-template-columns: 1fr; gap:10px;">
                @foreach ($cart as $item)
                    <div class="card" style="display:flex; align-items:center; justify-content:space-between; gap:14px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; background:color-mix(in srgb, var(--accent) 10%, white); font-size:20px;">
                                📦
                            </div>
                            <div>
                                <div style="font-weight:700;">{{ $item['name'] }}</div>
                                <div style="font-size:13px; color:var(--muted);">
                                    📂 {{ $item['category'] }} &middot; Cant.: <strong>{{ $item['qty'] }}</strong>
                                </div>
                            </div>
                        </div>

                        <div style="text-align:right;">
                            <div style="font-weight:700;">
                                {{ number_format($item['price'] * $item['qty'], 2, ',', '.') }} €
                            </div>
                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                @csrf
                                <button type="submit"
                                        style="margin-top:6px; padding:6px 10px; border-radius:999px; background:var(--accent); color:#fff; border:none; cursor:pointer;">
                                    Quitar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div style="margin-top:12px; text-align:right; font-size:18px;">
                Total: <strong>{{ number_format($total, 2, ',', '.') }} €</strong>
            </div>

            {{-- Vaciar carrito --}}
            <form method="POST" action="{{ route('cart.clear') }}" style="margin-top:10px; text-align:right;">
                @csrf
                <button type="submit"
                        style="padding:8px 14px; border-radius:999px; background:var(--accent); color:#fff; border:none;">
                    Vaciar carrito 🧹
                </button>
            </form>
        </div>
    @endif
@endsection

