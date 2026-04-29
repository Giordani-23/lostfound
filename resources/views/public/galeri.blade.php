@extends('layouts.app')

@section('title', 'Barang Temuan')

@section('content')

<div style="background:var(--bg-card);padding:4rem 2rem;border-bottom:1px solid var(--border)">
    <div style="max-width:1200px;margin:0 auto;text-align:center">
        <h1 style="font-size:2.5rem;font-weight:900;color:var(--accent);margin-bottom:1rem;letter-spacing:-0.03em">📦 Galeri Barang Temuan</h1>
        <p style="font-size:1.1rem;color:var(--text-muted);font-weight:500;max-width:600px;margin:0 auto">Semua barang yang ditemukan di area sekolah ada di sini. Coba cari barangmu pakai filter di bawah.</p>
    </div>
</div>

<section class="section" style="padding-top:2rem">
    <div class="section-inner">
        {{-- FILTER --}}
        <div class="card card-body mb-4" style="background:#fff;border-radius:var(--radius);padding:1.5rem">
            <form method="GET" action="{{ route('barang.index') }}">
                <div style="display:grid;grid-template-columns:2.5fr 1fr 1.5fr auto;gap:1.5rem;align-items:end">
                    <div class="form-group" style="margin:0">
                        <label class="form-label">Cari Nama Barang</label>
                        <input type="text" name="search" class="form-control" placeholder="Ketik apa yang hilang..." value="{{ request('search') }}" style="border-radius:var(--radius-pill);padding:0.75rem 1.5rem">
                    </div>
                    <div class="form-group" style="margin:0">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-control" style="border-radius:var(--radius-pill);padding:0.75rem 1.5rem">
                            <option value="">Semua</option>
                            @foreach(['Elektronik','Alat Tulis','Pakaian','Aksesoris','Lainnya'] as $k)
                                <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin:0">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="cth: Kantin..." value="{{ request('lokasi') }}" style="border-radius:var(--radius-pill);padding:0.75rem 1.5rem">
                    </div>
                    <div style="display:flex;gap:0.75rem">
                        <button type="submit" class="btn btn-primary" style="padding:0.75rem 1.5rem;border-radius:var(--radius-pill)">🔍 Cari</button>
                        @if(request()->anyFilled(['search', 'kategori', 'lokasi']))
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary" style="padding:0.75rem 1.5rem;border-radius:var(--radius-pill)">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- HASIL --}}
        @if($barangs->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Waduh, Nggak Ketemu!</h3>
                <p>Coba ganti kata kunci atau filter pencariannya ya.</p>
            </div>
        @else
            <p style="color:var(--text-muted);font-weight:600;font-size:0.9rem;margin-bottom:1.5rem">
                ✨ Ketemu {{ $barangs->total() }} barang
            </p>
            
            <div class="barang-grid">
                @foreach($barangs as $barang)
                <a href="{{ route('barang.show', $barang->id) }}" class="barang-card card-hover">
                    <div class="barang-card-img">
                        @if($barang->foto_utama)
                            <img src="{{ asset('storage/barang/' . $barang->foto_utama) }}" alt="{{ $barang->nama_barang }}">
                        @else
                            <div class="no-photo"><span>📷</span>Belum ada foto</div>
                        @endif
                        <div style="position:absolute;top:25px;right:25px">
                            @if($barang->status === 'tersimpan')
                                <span class="badge" style="background:#ECFDF5;color:#047857;box-shadow:0 4px 10px rgba(0,0,0,0.1)">✅ Tersimpan</span>
                            @elseif($barang->status === 'diklaim')
                                <span class="badge" style="background:#FFFBEB;color:#B45309;box-shadow:0 4px 10px rgba(0,0,0,0.1)">⏳ Proses Klaim</span>
                            @endif
                        </div>
                    </div>
                    <div class="barang-card-body">
                        <h3>{{ $barang->nama_barang }}</h3>
                        <div class="barang-card-meta">
                            <span>📍 {{ $barang->lokasi_ditemukan }}</span>
                            <span>📅 {{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-between align-center">
                            <span class="badge badge-info">{{ $barang->kategori }}</span>
                            <span style="font-size:0.85rem;color:var(--primary);font-weight:700">Lihat Detail →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="pagination">
                {{ $barangs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
