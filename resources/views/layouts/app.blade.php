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
            <div class="brand-icon">🔍</div>
            <div>
                <div>Lost & Found</div>
                <div style="font-size:0.7rem;font-weight:400;opacity:0.75">SMKN 1 Surabaya</div>
            </div>
        </a>
        <div class="navbar-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">Barang Temuan</a>
            <a href="{{ route('login') }}" class="btn-login-nav">Login Admin</a>
        </div>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
    <div style="max-width:1200px;margin:1rem auto;padding:0 2rem">
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div style="max-width:1200px;margin:1rem auto;padding:0 2rem">
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    </div>
@endif

{{-- CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer>
    <p>&copy; {{ date('Y') }} <strong>SMKN 1 Surabaya</strong> — Sistem Lost & Found Digital</p>
    <p style="margin-top:4px;font-size:0.78rem">Jl. SMEA No.4, Wonokromo, Surabaya</p>
</footer>

@stack('scripts')
</body>
</html>
