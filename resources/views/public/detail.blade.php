@extends('layouts.app')

@section('title', $barang->nama_barang)

@section('content')

<section class="section">
    <div class="section-inner">

        <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm mb-3">← Kembali ke Galeri</a>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;align-items:start">

            {{-- FOTO --}}
            <div>
                <div style="border-radius:var(--radius);overflow:hidden;background:var(--bg);aspect-ratio:4/3">
                    @if($barang->foto_utama)
                        <img src="{{ asset('storage/barang/' . $barang->foto_utama) }}"
                             alt="{{ $barang->nama_barang }}"
                             style="width:100%;height:100%;object-fit:cover">
                    @else
                        <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);gap:8px">
                            <span style="font-size:4rem">📷</span>
                            <p>Tidak ada foto</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- INFO BARANG --}}
            <div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-between align-center mb-2">
                            <span class="badge badge-info">{{ $barang->kode_unik }}</span>
                            @if($barang->status === 'tersimpan')
                                <span class="badge badge-success">✅ Tersimpan — Bisa Diklaim</span>
                            @elseif($barang->status === 'diklaim')
                                <span class="badge badge-warning">⏳ Sedang Diproses</span>
                            @else
                                <span class="badge badge-secondary">✔️ Sudah Dikembalikan</span>
                            @endif
                        </div>

                        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:1rem">{{ $barang->nama_barang }}</h1>

                        <div style="display:flex;flex-direction:column;gap:0.75rem;margin-bottom:1.5rem">
                            <div style="display:grid;grid-template-columns:140px 1fr;gap:0.5rem;font-size:0.9rem">
                                <span style="color:var(--text-muted);font-weight:600">📁 Kategori</span>
                                <span>{{ $barang->kategori }}</span>
                            </div>
                            <div style="display:grid;grid-template-columns:140px 1fr;gap:0.5rem;font-size:0.9rem">
                                <span style="color:var(--text-muted);font-weight:600">📍 Lokasi</span>
                                <span>{{ $barang->lokasi_ditemukan }}</span>
                            </div>
                            <div style="display:grid;grid-template-columns:140px 1fr;gap:0.5rem;font-size:0.9rem">
                                <span style="color:var(--text-muted);font-weight:600">📅 Tanggal</span>
                                <span>{{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d F Y') }}, {{ substr($barang->jam_ditemukan, 0, 5) }} WIB</span>
                            </div>
                            <div style="display:grid;grid-template-columns:140px 1fr;gap:0.5rem;font-size:0.9rem">
                                <span style="color:var(--text-muted);font-weight:600">🔧 Kondisi</span>
                                <span>{{ $barang->kondisi }}</span>
                            </div>
                            <div style="display:grid;grid-template-columns:140px 1fr;gap:0.5rem;font-size:0.9rem">
                                <span style="color:var(--text-muted);font-weight:600">👤 Ditemukan oleh</span>
                                <span>{{ $barang->ditemukan_oleh }}</span>
                            </div>
                            @if($barang->deskripsi)
                            <div style="display:grid;grid-template-columns:140px 1fr;gap:0.5rem;font-size:0.9rem">
                                <span style="color:var(--text-muted);font-weight:600">📝 Keterangan</span>
                                <span>{{ $barang->deskripsi }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- FORM KLAIM --}}
                        @if($barang->status === 'tersimpan')
                            <hr class="divider">
                            <h3 style="font-weight:700;margin-bottom:0.25rem">📝 Ini Barang Saya!</h3>
                            <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1.25rem">
                                Isi form di bawah untuk mengajukan klaim. Pastikan kamu menyebutkan ciri khusus yang hanya kamu yang tahu.
                            </p>

                            @if($errors->any())
                                <div class="alert alert-error mb-2">
                                    ❌ {{ $errors->first() }}
                                </div>
                            @endif

                            <form action="{{ route('barang.klaim', $barang->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="nama_pengklaim" class="form-control {{ $errors->has('nama_pengklaim') ? 'is-invalid' : '' }}"
                                           placeholder="Nama sesuai kartu pelajar" value="{{ old('nama_pengklaim') }}">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Kelas <span class="required">*</span></label>
                                        <input type="text" name="kelas" class="form-control"
                                               placeholder="cth: XI RPL 2" value="{{ old('kelas') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">No. WhatsApp <span class="required">*</span></label>
                                        <input type="text" name="no_hp" class="form-control"
                                               placeholder="cth: 08123456789" value="{{ old('no_hp') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Ciri Khusus Barang <span class="required">*</span></label>
                                    <textarea name="ciri_khusus" class="form-control {{ $errors->has('ciri_khusus') ? 'is-invalid' : '' }}"
                                              placeholder="Jelaskan ciri unik yang hanya kamu yang tahu. Contoh: ada goresan di pojok, isi dompet ada KTP atas nama..., ada stiker warna merah di belakang, dll."
                                              rows="4">{{ old('ciri_khusus') }}</textarea>
                                    <p class="form-hint">💡 Semakin detail, semakin mudah diverifikasi petugas.</p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    📤 Ajukan Klaim
                                </button>
                            </form>

                        @elseif($barang->status === 'diklaim')
                            <div class="alert alert-warning">
                                ⏳ <strong>Barang ini sedang dalam proses verifikasi klaim.</strong>
                                Silakan hubungi petugas piket jika kamu merasa ini milikmu.
                            </div>
                        @else
                            <div class="alert alert-success">
                                ✅ Barang ini sudah berhasil dikembalikan ke pemiliknya.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
