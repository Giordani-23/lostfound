@extends('layouts.app')

@section('title', 'Barang Temuan')

@section('content')

<section class="section">
    <div class="section-inner">
        <h2 class="section-title">📦 Barang Temuan</h2>
        <p class="section-sub">Daftar semua barang yang ditemukan dan disimpan di ruang piket SMKN 1 Surabaya.</p>

        {{-- FILTER --}}
        <div class="card card-body mb-3">
            <form method="GET" action="{{ route('barang.index') }}">
                <div style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:1rem;align-items:end">
                    <div class="form-group" style="margin:0">
                        <label class="form-label">Cari Barang</label>
                        <input type="text" name="search" class="form-control" placeholder="Ketik nama barang..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group" style="margin:0">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="">Semua</option>
                            @foreach(['Elektronik','Alat Tulis','Pakaian','Aksesoris','Lainnya'] as $k)
                                <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin:0">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="cth: Kantin..." value="{{ request('lokasi') }}">
                    </div>
                    <div style="display:flex;gap:0.5rem">
                        <button type="submit" class="btn btn-primary">🔍 Cari</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        {{-- HASIL --}}
        @if($barangs->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Tidak ada barang ditemukan</h3>
                <p>Coba ubah kata kunci atau filter pencarian.</p>
            </div>
        @else
            <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:1rem">
                Menampilkan {{ $barangs->firstItem() }}–{{ $barangs->lastItem() }} dari {{ $barangs->total() }} barang
            </p>
            <div class="barang-grid">
                @foreach($barangs as $barang)
                <a href="{{ route('barang.show', $barang->id) }}" class="barang-card" style="color:inherit">
                    <div class="barang-card-img">
                        @if($barang->foto_utama)
                            <img src="{{ asset('storage/barang/' . $barang->foto_utama) }}" alt="{{ $barang->nama_barang }}">
                        @else
                            <div class="no-photo"><span>📷</span>Tidak ada foto</div>
                        @endif
                        <div style="position:absolute;top:10px;right:10px">
                            @if($barang->status === 'tersimpan')
                                <span class="badge badge-success">✅ Tersimpan</span>
                            @elseif($barang->status === 'diklaim')
                                <span class="badge badge-warning">⏳ Diklaim</span>
                            @endif
                        </div>
                    </div>
                    <div class="barang-card-body">
                        <h3>{{ $barang->nama_barang }}</h3>
                        <div class="barang-card-meta">
                            <span>📍 {{ $barang->lokasi_ditemukan }}</span>
                            <span>📅 {{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d M Y') }}</span>
                            <span>🏷️ {{ $barang->kategori }}</span>
                        </div>
                        <div class="d-flex justify-between align-center">
                            <span class="badge badge-info" style="font-size:0.7rem">{{ $barang->kode_unik }}</span>
                            <span style="font-size:0.8rem;color:var(--primary);font-weight:600">Lihat Detail →</span>
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
