@extends('layouts.admin')

@section('title', $barang->nama_barang)
@section('page-title', 'Detail Barang')

@section('topbar-actions')
    <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-primary btn-sm">✏️ Edit</a>
@endsection

@section('content')

<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:1.5rem;align-items:start">

    {{-- KOLOM KIRI: FOTO + QR --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- FOTO --}}
        <div class="card card-body">
            <h3 style="font-weight:700;margin-bottom:1rem">📷 Foto Barang</h3>
            <div style="border-radius:var(--radius-sm);overflow:hidden;background:var(--bg);aspect-ratio:4/3">
                @if($barang->foto_utama)
                    <img src="{{ asset('uploads/barang/' . $barang->foto_utama) }}"
                         alt="{{ $barang->nama_barang }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);gap:8px">
                        <span style="font-size:3rem">📷</span>
                        <p style="font-size:0.85rem">Tidak ada foto</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- LABEL QR UNTUK DICETAK --}}
        <div class="card card-body">
            <h3 style="font-weight:700;margin-bottom:1rem">🖨️ Label QR</h3>
            <div style="text-align:center;padding:1rem;border:2px dashed var(--border);border-radius:var(--radius-sm)" id="qr-preview">
                <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.05em;color:var(--text-muted)">SMKN 1 SURABAYA — LOST & FOUND</p>
                <div style="margin:0.75rem auto;display:flex;justify-content:center">
                    {!! $qrCode !!}
                </div>
                <p style="font-weight:800;font-size:0.95rem">{{ $barang->kode_unik }}</p>
                <p style="font-size:0.8rem;margin-top:2px">{{ $barang->nama_barang }}</p>
                <p style="font-size:0.75rem;color:var(--text-muted)">📍 {{ $barang->lokasi_ditemukan }}</p>
                <p style="font-size:0.75rem;color:var(--text-muted)">📅 {{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->format('d/m/Y') }}</p>
            </div>
            <button onclick="window.print()" class="btn btn-accent btn-block mt-2">
                🖨️ Cetak Label QR
            </button>
            <p style="font-size:0.78rem;color:var(--text-muted);text-align:center;margin-top:0.5rem">
                Pastikan thermal printer sudah jadi default printer
            </p>
        </div>
    </div>

    {{-- KOLOM KANAN: INFO + KLAIM --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- INFO BARANG --}}
        <div class="card card-body">
            <div class="d-flex justify-between align-center mb-2">
                <h3 style="font-weight:700">📦 Info Barang</h3>
                @if($barang->status === 'tersimpan')
                    <span class="badge badge-success">✅ Tersimpan</span>
                @elseif($barang->status === 'diklaim')
                    <span class="badge badge-warning">⏳ Diklaim</span>
                @else
                    <span class="badge badge-secondary">✔️ Dikembalikan</span>
                @endif
            </div>

            <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:1.25rem">{{ $barang->nama_barang }}</h2>

            <div style="display:flex;flex-direction:column;gap:0.65rem">
                @foreach([
                    ['📌 Kode Unik', $barang->kode_unik],
                    ['📁 Kategori', $barang->kategori],
                    ['📍 Lokasi', $barang->lokasi_ditemukan],
                    ['📅 Tanggal', \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d F Y') . ', ' . substr($barang->jam_ditemukan,0,5) . ' WIB'],
                    ['🔧 Kondisi', $barang->kondisi],
                    ['👤 Ditemukan oleh', $barang->ditemukan_oleh],
                ] as [$label, $value])
                <div style="display:grid;grid-template-columns:160px 1fr;gap:0.5rem;font-size:0.9rem;padding-bottom:0.65rem;border-bottom:1px solid var(--border)">
                    <span style="color:var(--text-muted);font-weight:600">{{ $label }}</span>
                    <span style="font-weight:500">{{ $value }}</span>
                </div>
                @endforeach
                @if($barang->deskripsi)
                <div style="display:grid;grid-template-columns:160px 1fr;gap:0.5rem;font-size:0.9rem">
                    <span style="color:var(--text-muted);font-weight:600">📝 Keterangan</span>
                    <span>{{ $barang->deskripsi }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- DAFTAR KLAIM MASUK --}}
        <div class="card">
            <div class="card-header">
                <h3>📋 Klaim Masuk ({{ $barang->klaims->count() }})</h3>
            </div>
            @if($barang->klaims->isEmpty())
                <div class="card-body">
                    <div class="empty-state" style="padding:1.5rem">
                        <p>Belum ada yang mengajukan klaim</p>
                    </div>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Pengklaim</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang->klaims as $klaim)
                            <tr>
                                <td>
                                    <div style="font-weight:600">{{ $klaim->nama_pengklaim }}</div>
                                    <div style="font-size:0.8rem;color:var(--text-muted)">{{ $klaim->kelas }} · {{ $klaim->no_hp }}</div>
                                </td>
                                <td style="font-size:0.85rem">{{ $klaim->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($klaim->status === 'menunggu')
                                        <span class="badge badge-warning">⏳ Menunggu</span>
                                    @elseif($klaim->status === 'disetujui')
                                        <span class="badge badge-success">✅ Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">❌ Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.klaim.show', $klaim->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- STRUK SERAH TERIMA (hanya muncul saat print) --}}
@php $klaimDisetujui = $barang->klaims->where('status','disetujui')->first(); @endphp
@if($klaimDisetujui)
<div id="struk-cetak">
    <div style="text-align:center;border-bottom:1px dashed #000;padding-bottom:4mm;margin-bottom:3mm">
        <p style="font-weight:700;font-size:10pt">SMKN 1 SURABAYA</p>
        <p style="font-size:8pt">BUKTI SERAH TERIMA BARANG</p>
        <p style="font-size:8pt">LOST & FOUND</p>
    </div>
    <table style="width:100%;font-size:8pt;border-collapse:collapse">
        <tr><td style="width:35%;padding:1mm 0">No. Kode</td><td>: {{ $barang->kode_unik }}</td></tr>
        <tr><td>Barang</td><td>: {{ $barang->nama_barang }}</td></tr>
        <tr><td>Kondisi</td><td>: {{ $barang->kondisi }}</td></tr>
    </table>
    <div style="border-top:1px dashed #000;margin:3mm 0;padding-top:2mm;font-size:8pt">
        <p style="font-weight:700">DATA PENERIMA:</p>
        <table style="width:100%;border-collapse:collapse;font-size:8pt">
            <tr><td style="width:35%">Nama</td><td>: {{ $klaimDisetujui->nama_pengklaim }}</td></tr>
            <tr><td>Kelas</td><td>: {{ $klaimDisetujui->kelas }}</td></tr>
            <tr><td>No. HP</td><td>: {{ $klaimDisetujui->no_hp }}</td></tr>
        </table>
    </div>
    <div style="border-top:1px dashed #000;margin:3mm 0;padding-top:2mm;font-size:8pt">
        <p>Tanggal: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:4mm;margin-top:4mm;font-size:8pt;text-align:center">
        <div>
            <p>Diserahkan oleh,</p>
            <div style="margin-top:12mm;border-top:1px solid #000;padding-top:2mm">Petugas Piket</div>
        </div>
        <div>
            <p>Diterima oleh,</p>
            <div style="margin-top:12mm;border-top:1px solid #000;padding-top:2mm">{{ $klaimDisetujui->nama_pengklaim }}</div>
        </div>
    </div>
</div>
@endif

@endsection
