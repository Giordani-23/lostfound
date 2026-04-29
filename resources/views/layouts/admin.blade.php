<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Lost & Found SMKN 1 Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>🔍 Lost & Found</h2>
            <p>SMKN 1 Surabaya</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Dashboard
            </a>

            <div class="nav-section">Barang</div>
            <a href="{{ route('admin.barang.index') }}" class="{{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span> Semua Barang
            </a>
            <a href="{{ route('admin.barang.create') }}">
                <span class="nav-icon">➕</span> Tambah Barang
            </a>

            <div class="nav-section">Klaim</div>
            <a href="{{ route('admin.klaim.index') }}" class="{{ request()->routeIs('admin.klaim.*') ? 'active' : '' }}">
                <span class="nav-icon">📋</span> Kelola Klaim
            </a>

            <div class="nav-section">Lainnya</div>
            <a href="{{ route('home') }}" target="_blank">
                <span class="nav-icon">🌐</span> Lihat Website
            </a>
        </nav>

        <div class="sidebar-footer">
            <div style="color:rgba(255,255,255,0.5);font-size:0.8rem;margin-bottom:0.75rem">
                Login sebagai:<br>
                <strong style="color:#fff">{{ Auth::user()->name }}</strong>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="d-flex align-center gap-1">
                @yield('topbar-actions')
            </div>
        </div>

        <div class="admin-content">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</div>

@stack('scripts')
</body>
</html>
