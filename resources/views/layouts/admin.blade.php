<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Lost & Found SMKN 1 Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css">
    @stack('styles')
</head>
<body>

<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2><i class="fi fi-rr-search" style="margin-right:6px"></i> Lost & Found</h2>
            <p>SMKN 1 Surabaya</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fi fi-rr-apps"></i></span> Dashboard
            </a>

            <div class="nav-section">Barang</div>
            <a href="{{ route('admin.barang.index') }}" class="{{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fi fi-rr-box-open"></i></span> Semua Barang
            </a>
            <a href="{{ route('admin.barang.create') }}">
                <span class="nav-icon"><i class="fi fi-rr-add"></i></span> Tambah Barang
            </a>

            <div class="nav-section">Klaim</div>
            <a href="{{ route('admin.klaim.index') }}" class="{{ request()->routeIs('admin.klaim.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fi fi-rr-clipboard-list"></i></span> Kelola Klaim
            </a>

            <div class="nav-section">Lainnya</div>
            <a href="{{ route('home') }}" target="_blank">
                <span class="nav-icon"><i class="fi fi-rr-globe"></i></span> Lihat Website
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
                    <span><i class="fi fi-rr-sign-out-alt"></i></span> Logout
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
                <div class="alert alert-success"><i class="fi fi-sr-check-circle" style="margin-right:6px"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><i class="fi fi-sr-cross-circle" style="margin-right:6px"></i> {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</div>

@stack('scripts')
</body>
</html>
