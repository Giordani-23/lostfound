@extends('layouts.app')

@section('title', $barang->nama_barang)

@section('content')

<section class="section" style="padding-top:2rem">
    <div class="section-inner" style="max-width:1000px">

        <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm mb-4" style="border-radius:var(--radius-pill)">
            ← Kembali ke Galeri
        </a>

        <div style="display:grid;grid-template-columns:1fr 1.2fr;gap:3rem;align-items:start">

            {{-- FOTO (KIRI) --}}
            <div style="position:sticky;top:100px">
                <div style="background:#fff;padding:1rem;border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--border)">
                    <div style="border-radius:var(--radius-sm);overflow:hidden;background:var(--bg);aspect-ratio:4/3">
                        @if($barang->foto_utama)
                            <img src="{{ asset('uploads/barang/' . $barang->foto_utama) }}"
                                 alt="{{ $barang->nama_barang }}"
                                 style="width:100%;height:100%;object-fit:cover">
                        @else
                            <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);font-weight:600;gap:8px">
                                <span style="font-size:4rem;opacity:0.5"><i class="fi fi-rr-camera" style="font-size:4rem"></i></span>
                                <p>Belum ada foto</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- INFO BARANG & FORM (KANAN) --}}
            <div>
                <div class="d-flex align-center gap-2 mb-3">
                    <span class="badge badge-info" style="font-size:0.85rem">{{ $barang->kode_unik }}</span>
                    @if($barang->status === 'tersimpan')
                        <span class="badge" style="background:#ECFDF5;color:#047857;font-size:0.85rem"><i class="fi fi-sr-check-circle" style="margin-right:3px"></i> Tersedia untuk Diklaim</span>
                    @elseif($barang->status === 'diklaim')
                        <span class="badge" style="background:#FFFBEB;color:#B45309;font-size:0.85rem"><i class="fi fi-rr-clock-three" style="margin-right:3px"></i> Sedang Diverifikasi</span>
                    @else
                        <span class="badge" style="background:#F3F4F6;color:#374151;font-size:0.85rem"><i class="fi fi-rr-check-double" style="margin-right:3px"></i> Sudah Dikembalikan</span>
                    @endif
                </div>

                <h1 style="font-size:2rem;font-weight:900;margin-bottom:1.5rem;color:var(--accent);letter-spacing:-0.03em;line-height:1.2">
                    {{ $barang->nama_barang }}
                </h1>

                {{-- INFO DETAILS --}}
                <div style="background:#fff;border-radius:var(--radius);padding:1.5rem;border:1px solid var(--border);margin-bottom:2rem;display:flex;flex-direction:column;gap:1rem">
                    <div style="display:grid;grid-template-columns:120px 1fr;gap:1rem;font-size:0.95rem">
                        <span style="color:var(--text-muted);font-weight:700"><i class="fi fi-rr-folder" style="margin-right:4px"></i> Kategori</span>
                        <span style="font-weight:600">{{ $barang->kategori }}</span>
                    </div>
                    <div style="display:grid;grid-template-columns:120px 1fr;gap:1rem;font-size:0.95rem">
                        <span style="color:var(--text-muted);font-weight:700"><i class="fi fi-rr-marker" style="margin-right:4px"></i> Lokasi</span>
                        <span style="font-weight:600">{{ $barang->lokasi_ditemukan }}</span>
                    </div>
                    <div style="display:grid;grid-template-columns:120px 1fr;gap:1rem;font-size:0.95rem">
                        <span style="color:var(--text-muted);font-weight:700"><i class="fi fi-rr-calendar" style="margin-right:4px"></i> Tanggal</span>
                        <span style="font-weight:600">{{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d F Y') }}, {{ substr($barang->jam_ditemukan, 0, 5) }} WIB</span>
                    </div>
                    <div style="display:grid;grid-template-columns:120px 1fr;gap:1rem;font-size:0.95rem">
                        <span style="color:var(--text-muted);font-weight:700"><i class="fi fi-rr-wrench-simple" style="margin-right:4px"></i> Kondisi</span>
                        <span style="font-weight:600">{{ $barang->kondisi }}</span>
                    </div>
                    @if($barang->deskripsi)
                    <div style="display:grid;grid-template-columns:120px 1fr;gap:1rem;font-size:0.95rem;padding-top:1rem;border-top:1px dashed var(--border)">
                        <span style="color:var(--text-muted);font-weight:700"><i class="fi fi-rr-document" style="margin-right:4px"></i> Keterangan</span>
                        <span style="font-weight:500;line-height:1.6">{{ $barang->deskripsi }}</span>
                    </div>
                    @endif
                </div>

                {{-- FORM KLAIM --}}
                @if($barang->status === 'tersimpan')
                    <div style="background:var(--primary-subtle);border-radius:var(--radius);padding:2rem;border:2px solid rgba(255,122,0,0.1)">
                        <h3 style="font-weight:900;font-size:1.4rem;color:var(--accent);margin-bottom:0.5rem"><i class="fi fi-rr-document-signed" style="margin-right:6px"></i> Ini Barang Kamu?</h3>
                        <p style="font-size:0.95rem;color:var(--text-muted);font-weight:500;margin-bottom:1.5rem">
                            Isi form di bawah untuk klaim. Pastikan kamu nyebutin <strong>ciri khusus</strong> yang cuma kamu yang tahu biar gampang diverifikasi petugas.
                        </p>

                        @if($errors->any())
                            <div class="alert alert-error mb-3" style="background:#fff">
                                <i class="fi fi-sr-cross-circle" style="margin-right:4px"></i> {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('barang.klaim', $barang->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" name="nama_pengklaim" class="form-control {{ $errors->has('nama_pengklaim') ? 'is-invalid' : '' }}"
                                       placeholder="Nama sesuai kartu pelajar" value="{{ old('nama_pengklaim') }}" style="border-radius:var(--radius-sm);padding:0.85rem 1.25rem">
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
                                           placeholder="cth: 0812..." value="{{ old('no_hp') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Ciri Khusus Barang <span class="required">*</span></label>
                                <textarea name="ciri_khusus" class="form-control {{ $errors->has('ciri_khusus') ? 'is-invalid' : '' }}"
                                          placeholder="Jelasin se-detail mungkin! Contoh: di pojok dompet ada bekas jahitan lepas, atau di dalemnya ada KTP namaku..."
                                          rows="4">{{ old('ciri_khusus') }}</textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:1rem;font-size:1.1rem;padding:1.2rem">
                                <i class="fi fi-rr-paper-plane" style="margin-right:6px"></i> Kirim Pengajuan Klaim
                            </button>
                        </form>
                    </div>

                @elseif($barang->status === 'diklaim')
                    <div class="alert alert-warning" style="padding:1.5rem">
                        <div>
                            <h4 style="font-weight:800;font-size:1.1rem;margin-bottom:0.25rem;color:#92400E"><i class="fi fi-rr-clock-three" style="margin-right:4px"></i> Sedang Diverifikasi</h4>
                            <p style="color:#B45309;font-weight:500">Ada yang lagi ngajuin klaim buat barang ini. Kalau ngerasa ini punyamu, langsung datengin petugas piket aja ya!</p>
                        </div>
                    </div>
                @else
                    <div class="alert alert-success" style="padding:1.5rem">
                        <div>
                            <h4 style="font-weight:800;font-size:1.1rem;margin-bottom:0.25rem;color:#065F46"><i class="fi fi-sr-check-circle" style="margin-right:4px"></i> Sudah Diambil</h4>
                            <p style="color:#047857;font-weight:500">Barang ini udah berhasil balik ke pemilik aslinya. Yay!</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
