@extends('layouts.admin')

@section('title', 'Verifikasi Klaim')
@section('page-title', 'Verifikasi Klaim')

@section('topbar-actions')
    <a href="{{ route('admin.klaim.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
@endsection

@section('content')

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

    {{-- KOLOM KIRI: INFO BARANG --}}
    <div class="card card-body">
        <h3 style="font-weight:700;margin-bottom:1rem">📦 Barang yang Diklaim</h3>

        <div style="border-radius:var(--radius-sm);overflow:hidden;background:var(--bg);height:220px;margin-bottom:1.25rem">
            @if($klaim->barang->foto_utama)
                <img src="{{ asset('storage/barang/' . $klaim->barang->foto_utama) }}"
                     style="width:100%;height:100%;object-fit:cover">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem">📷</div>
            @endif
        </div>

        <div style="display:flex;flex-direction:column;gap:0.6rem">
            @foreach([
                ['Kode', $klaim->barang->kode_unik],
                ['Nama', $klaim->barang->nama_barang],
                ['Kategori', $klaim->barang->kategori],
                ['Lokasi', $klaim->barang->lokasi_ditemukan],
                ['Kondisi', $klaim->barang->kondisi],
            ] as [$label, $value])
            <div style="display:grid;grid-template-columns:100px 1fr;font-size:0.88rem;padding-bottom:0.6rem;border-bottom:1px solid var(--border)">
                <span style="color:var(--text-muted);font-weight:600">{{ $label }}</span>
                <span>{{ $value }}</span>
            </div>
            @endforeach
        </div>

        <a href="{{ route('admin.barang.show', $klaim->barang->id) }}" class="btn btn-outline btn-sm mt-2">
            Lihat Detail Barang
        </a>
    </div>

    {{-- KOLOM KANAN: INFO KLAIM + VERIFIKASI --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- INFO PENGKLAIM --}}
        <div class="card card-body">
            <div class="d-flex justify-between align-center mb-2">
                <h3 style="font-weight:700">👤 Data Pengklaim</h3>
                @if($klaim->status === 'menunggu')
                    <span class="badge badge-warning">⏳ Menunggu</span>
                @elseif($klaim->status === 'disetujui')
                    <span class="badge badge-success">✅ Disetujui</span>
                @else
                    <span class="badge badge-danger">❌ Ditolak</span>
                @endif
            </div>

            <div style="display:flex;flex-direction:column;gap:0.6rem;margin-bottom:1.25rem">
                @foreach([
                    ['Nama', $klaim->nama_pengklaim],
                    ['Kelas', $klaim->kelas],
                    ['No. HP', $klaim->no_hp],
                    ['Tgl. Klaim', $klaim->created_at->format('d/m/Y H:i')],
                ] as [$label, $value])
                <div style="display:grid;grid-template-columns:100px 1fr;font-size:0.88rem;padding-bottom:0.6rem;border-bottom:1px solid var(--border)">
                    <span style="color:var(--text-muted);font-weight:600">{{ $label }}</span>
                    <span style="font-weight:500">{{ $value }}</span>
                </div>
                @endforeach
            </div>

            {{-- CIRI KHUSUS --}}
            <div style="background:var(--bg);border-radius:var(--radius-sm);padding:1rem;border-left:4px solid var(--accent)">
                <p style="font-size:0.8rem;font-weight:700;color:var(--accent);margin-bottom:0.4rem">🔑 CIRI KHUSUS YANG DISEBUTKAN</p>
                <p style="font-size:0.9rem;line-height:1.7">{{ $klaim->ciri_khusus }}</p>
            </div>

            @if($klaim->catatan_admin)
                <div class="alert {{ $klaim->status === 'disetujui' ? 'alert-success' : 'alert-error' }} mt-2">
                    <strong>Catatan Admin:</strong> {{ $klaim->catatan_admin }}
                </div>
            @endif
        </div>

        {{-- FORM VERIFIKASI (hanya jika masih menunggu) --}}
        @if($klaim->status === 'menunggu')
        <div class="card card-body">
            <h3 style="font-weight:700;margin-bottom:0.5rem">⚖️ Keputusan Verifikasi</h3>
            <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1.25rem">
                Cocokkan ciri khusus di atas dengan barang asli sebelum membuat keputusan.
            </p>

            <form action="{{ route('admin.klaim.update', $klaim->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Catatan (opsional jika setujui, wajib jika tolak)</label>
                    <textarea name="catatan_admin" class="form-control" rows="3"
                              placeholder="Tulis alasan atau keterangan..."></textarea>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <button type="submit" name="aksi" value="setujui" class="btn btn-success btn-lg"
                            onclick="return confirm('Setujui klaim ini? Barang akan ditandai sebagai dikembalikan.')">
                        ✅ Setujui Klaim
                    </button>
                    <button type="submit" name="aksi" value="tolak" class="btn btn-danger btn-lg"
                            onclick="return confirm('Tolak klaim ini? Masukkan alasan penolakan di kolom catatan.')">
                        ❌ Tolak Klaim
                    </button>
                </div>
            </form>
        </div>

        {{-- JIKA SUDAH DISETUJUI: Tampilkan tombol cetak struk --}}
        @elseif($klaim->status === 'disetujui')
        <div class="card card-body text-center">
            <p style="font-size:2rem;margin-bottom:0.5rem">✅</p>
            <h3 style="font-weight:700;margin-bottom:0.5rem">Klaim Telah Disetujui</h3>
            <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1.25rem">
                Cetak struk serah terima dan minta tanda tangan pemilik saat barang diambil.
            </p>
            <button onclick="window.print()" class="btn btn-accent btn-lg btn-block">
                🖨️ Cetak Struk Serah Terima
            </button>
        </div>
        @endif
    </div>
</div>

{{-- STRUK SERAH TERIMA (hanya muncul saat print) --}}
<div id="struk-cetak">
    <div style="text-align:center;border-bottom:1px dashed #000;padding-bottom:4mm;margin-bottom:3mm">
        <p style="font-weight:700;font-size:11pt">SMKN 1 SURABAYA</p>
        <p style="font-size:8pt">Jl. SMEA No.4, Wonokromo, Surabaya</p>
        <div style="margin:2mm 0;border-top:1px solid #000;border-bottom:1px solid #000;padding:1mm 0">
            <p style="font-weight:700;font-size:9pt">BUKTI SERAH TERIMA BARANG</p>
            <p style="font-size:8pt">LOST & FOUND</p>
        </div>
    </div>

    <table style="width:100%;font-size:8pt;border-collapse:collapse">
        <tr><td style="width:38%;padding:1mm 0;font-weight:600">Kode Barang</td><td>: {{ $klaim->barang->kode_unik }}</td></tr>
        <tr><td style="font-weight:600">Nama Barang</td><td>: {{ $klaim->barang->nama_barang }}</td></tr>
        <tr><td style="font-weight:600">Kondisi</td><td>: {{ $klaim->barang->kondisi }}</td></tr>
        <tr><td style="font-weight:600">Ditemukan di</td><td>: {{ $klaim->barang->lokasi_ditemukan }}</td></tr>
    </table>

    <div style="border-top:1px dashed #000;margin:3mm 0;padding-top:2mm;font-size:8pt">
        <p style="font-weight:700;margin-bottom:1mm">DATA PENERIMA:</p>
        <table style="width:100%;border-collapse:collapse;font-size:8pt">
            <tr><td style="width:38%;font-weight:600">Nama</td><td>: {{ $klaim->nama_pengklaim }}</td></tr>
            <tr><td style="font-weight:600">Kelas</td><td>: {{ $klaim->kelas }}</td></tr>
            <tr><td style="font-weight:600">No. HP</td><td>: {{ $klaim->no_hp }}</td></tr>
        </table>
    </div>

    <div style="border-top:1px dashed #000;margin:3mm 0;padding-top:2mm;font-size:8pt">
        <p>Tanggal Pengambilan: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:6mm;margin-top:6mm;font-size:8pt;text-align:center">
        <div>
            <p>Diserahkan oleh,</p>
            <div style="height:14mm"></div>
            <div style="border-top:1px solid #000;padding-top:1mm">( Petugas Piket )</div>
        </div>
        <div>
            <p>Diterima oleh,</p>
            <div style="height:14mm"></div>
            <div style="border-top:1px solid #000;padding-top:1mm">( {{ $klaim->nama_pengklaim }} )</div>
        </div>
    </div>
</div>

@endsection
