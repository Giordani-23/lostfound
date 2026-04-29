@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-content">
        <div style="display:inline-block;padding:0.5rem 1rem;background:var(--primary-subtle);color:var(--primary-dark);border-radius:var(--radius-pill);font-weight:700;font-size:0.85rem;margin-bottom:1.5rem;letter-spacing:0.05em">
            SELAMAT DATANG DI LOST & FOUND
        </div>
        <h1>Barang Hilang?<br><span>Jangan Panik Dulu!</span></h1>
        <p>Cek di sini! Kami menyimpan semua barang temuan yang ada di area SMKN 1 Surabaya dan siap mengembalikannya ke kamu.</p>
        
        <div class="d-flex gap-2 justify-center flex-wrap" style="justify-content:center">
            <a href="{{ route('barang.index') }}" class="btn btn-primary btn-lg" style="font-size:1.1rem;padding:1.2rem 2.5rem">
                🔎 Cari Barangku
            </a>
        </div>
    </div>

    <div class="hero-stats">
        <div class="hero-stat">
            <h2>{{ $totalBarang }}</h2>
            <p>Total Ditemukan</p>
        </div>
        <div class="hero-stat">
            <h2 style="color:var(--primary)">{{ $totalTersimpan }}</h2>
            <p>Menunggu Diambil</p>
        </div>
        <div class="hero-stat">
            <h2 style="color:var(--success)">{{ $totalDikembalikan }}</h2>
            <p>Berhasil Kembali</p>
        </div>
    </div>
</section>

{{-- CARA PENGGUNAAN --}}
<section class="section" style="background:var(--bg)">
    <div class="section-inner text-center">
        <h2 class="section-title">Cara Klaim Barangmu</h2>
        <p class="section-sub">3 langkah super gampang buat ngambil barang yang hilang</p>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:2.5rem;margin-top:2rem">
            <div class="card card-hover card-body text-center" style="border:none">
                <div style="width:80px;height:80px;background:var(--primary-subtle);color:var(--primary);border-radius:24px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 1.5rem">
                    👀
                </div>
                <h3 style="font-weight:800;font-size:1.3rem;margin-bottom:0.75rem;color:var(--accent)">1. Cari Barang</h3>
                <p style="color:var(--text-muted);font-weight:500">Buka halaman Barang Temuan dan cari barangmu berdasarkan nama, kategori, atau lokasi.</p>
            </div>
            
            <div class="card card-hover card-body text-center" style="border:none">
                <div style="width:80px;height:80px;background:#FEF3C7;color:#D97706;border-radius:24px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 1.5rem">
                    ✍️
                </div>
                <h3 style="font-weight:800;font-size:1.3rem;margin-bottom:0.75rem;color:var(--accent)">2. Ajukan Klaim</h3>
                <p style="color:var(--text-muted);font-weight:500">Isi form klaim dengan nama, kelas, dan ciri khusus barang yang cuma kamu yang tahu.</p>
            </div>
            
            <div class="card card-hover card-body text-center" style="border:none">
                <div style="width:80px;height:80px;background:#D1FAE5;color:#059669;border-radius:24px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 1.5rem">
                    🎉
                </div>
                <h3 style="font-weight:800;font-size:1.3rem;margin-bottom:0.75rem;color:var(--accent)">3. Ambil Barang</h3>
                <p style="color:var(--text-muted);font-weight:500">Setelah diverifikasi, temui petugas piket untuk ambil barangmu. Yeay!</p>
            </div>
        </div>
    </div>
</section>

{{-- BARANG TERBARU --}}
<section class="section" style="background:#fff">
    <div class="section-inner">
        <div class="d-flex justify-between align-center flex-wrap gap-2 mb-4">
            <div>
                <h2 class="section-title">Barang Baru Ditemukan</h2>
                <p class="section-sub" style="margin-bottom:0">Siapa tahu ini punya kamu yang hilang hari ini.</p>
            </div>
            <a href="{{ route('barang.index') }}" class="btn btn-primary" style="background:var(--primary-subtle);color:var(--primary-dark)">Lihat Semua →</a>
        </div>

        @if($barangTerbaru->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Lagi Kosong Nih!</h3>
                <p>Belum ada barang temuan terbaru hari ini.</p>
            </div>
        @else
            <div class="barang-grid">
                @foreach($barangTerbaru as $barang)
                <a href="{{ route('barang.show', $barang->id) }}" class="barang-card card-hover">
                    <div class="barang-card-img">
                        @if($barang->foto_utama)
                            <img src="{{ asset('storage/barang/' . $barang->foto_utama) }}" alt="{{ $barang->nama_barang }}">
                        @else
                            <div class="no-photo"><span>📷</span>Belum ada foto</div>
                        @endif
                    </div>
                    <div class="barang-card-body">
                        <h3>{{ $barang->nama_barang }}</h3>
                        <div class="barang-card-meta">
                            <span>📍 {{ $barang->lokasi_ditemukan }}</span>
                            <span>📅 {{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-between align-center">
                            <span class="badge badge-info">{{ $barang->kategori }}</span>
                            <span class="badge badge-success" style="background:#ECFDF5;color:#047857">Tersimpan</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
