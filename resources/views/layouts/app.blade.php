<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lost & Found') — SMKN 1 Surabaya</title>
    <meta name="description" content="@yield('meta_desc', 'Sistem Lost & Found digital SMKN 1 Surabaya. Temukan barang hilangmu dengan mudah.')">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div style="line-height:1.2">
                <div>Lost & Found</div>
                <div style="font-size:0.75rem;font-weight:600;opacity:0.6;letter-spacing:0.05em;text-transform:uppercase">SMKN 1 Surabaya</div>
            </div>
        </a>
        <div class="navbar-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">Barang Temuan</a>
            <a href="{{ route('login') }}" class="btn btn-login-nav" style="border-radius:var(--radius-pill);padding:0.6rem 1.5rem">Login Admin</a>
        </div>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
    <div style="max-width:1200px;margin:2rem auto 0;padding:0 2rem">
        <div class="alert alert-success">✨ {{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div style="max-width:1200px;margin:2rem auto 0;padding:0 2rem">
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    </div>
@endif

{{-- CONTENT --}}
<div style="min-height:70vh">
    @yield('content')
</div>

{{-- FOOTER --}}
<footer>
    <div style="max-width:1200px;margin:0 auto;display:flex;flex-direction:column;align-items:center;gap:1rem">
        <div style="font-size:2.5rem;color:var(--primary)">Wenakkk</div>
        <p>&copy; {{ date('Y') }} <strong>SMKN 1 Surabaya</strong> — Sistem Lost & Found Digital</p>
        <p style="font-size:0.85rem">Jl. SMEA No.4, Wonokromo, Surabaya</p>
    </div>
</footer>

@stack('scripts')
</body>
</html>
