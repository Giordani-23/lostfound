@extends('layouts.admin')

@section('title', $barang->nama_barang)
@section('page-title', 'Detail Barang')

@section('topbar-actions')
    <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-primary btn-sm"><i class="fi fi-rr-pencil" style="margin-right:4px"></i> Edit</a>
@endsection

@section('content')

<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:1.5rem;align-items:start">

    {{-- KOLOM KIRI: FOTO + QR --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- FOTO --}}
        <div class="card card-body">
            <h3 style="font-weight:700;margin-bottom:1rem"><i class="fi fi-rr-camera" style="margin-right:6px"></i> Foto Barang</h3>
            <div style="border-radius:var(--radius-sm);overflow:hidden;background:var(--bg);aspect-ratio:4/3">
                @if($barang->foto_utama)
                    <img src="{{ asset('uploads/barang/' . $barang->foto_utama) }}"
                         alt="{{ $barang->nama_barang }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);gap:8px">
                        <span style="font-size:3rem"><i class="fi fi-rr-camera" style="font-size:3rem;opacity:0.5"></i></span>
                        <p style="font-size:0.85rem">Tidak ada foto</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- LABEL QR UNTUK DICETAK --}}
        <div class="card card-body">
            <h3 style="font-weight:700;margin-bottom:1rem"><i class="fi fi-rr-print" style="margin-right:6px"></i> Label QR</h3>
            <div style="text-align:center;padding:1rem;border:2px dashed var(--border);border-radius:var(--radius-sm)" id="qr-preview">
                <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.05em;color:var(--text-muted)">SMKN 1 SURABAYA — LOST & FOUND</p>
                <div style="margin:0.75rem auto;display:flex;justify-content:center">
                    {!! $qrCode !!}
                </div>
                <p style="font-weight:800;font-size:0.95rem">{{ $barang->kode_unik }}</p>
                <p style="font-size:0.8rem;margin-top:2px">{{ $barang->nama_barang }}</p>
                <p style="font-size:0.75rem;color:var(--text-muted)"><i class="fi fi-rr-marker" style="margin-right:2px"></i> {{ $barang->lokasi_ditemukan }}</p>
                <p style="font-size:0.75rem;color:var(--text-muted)"><i class="fi fi-rr-calendar" style="margin-right:2px"></i> {{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('admin.barang.print-label', $barang->id) }}" target="_blank" class="btn btn-accent btn-block mt-2">
                <i class="fi fi-rr-print" style="margin-right:4px"></i> Cetak Label QR
            </a>
        </div>
    </div>

    {{-- KOLOM KANAN: INFO + KLAIM --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- INFO BARANG --}}
        <div class="card card-body">
            <div class="d-flex justify-between align-center mb-2">
                <h3 style="font-weight:700"><i class="fi fi-rr-box-open" style="margin-right:6px"></i> Info Barang</h3>
                @if($barang->status === 'tersimpan')
                    <span class="badge badge-success"><i class="fi fi-sr-check-circle" style="margin-right:3px"></i> Tersimpan</span>
                @elseif($barang->status === 'diklaim')
                    <span class="badge badge-warning"><i class="fi fi-rr-clock-three" style="margin-right:3px"></i> Diklaim</span>
                @else
                    <span class="badge badge-secondary"><i class="fi fi-rr-check-double" style="margin-right:3px"></i> Dikembalikan</span>
                @endif
            </div>

            <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:1.25rem">{{ $barang->nama_barang }}</h2>

            <div style="display:flex;flex-direction:column;gap:0.65rem">
                @foreach([
                    ['<i class="fi fi-rr-bookmark" style="margin-right:4px"></i> Kode Unik', $barang->kode_unik],
                    ['<i class="fi fi-rr-folder" style="margin-right:4px"></i> Kategori', $barang->kategori],
                    ['<i class="fi fi-rr-marker" style="margin-right:4px"></i> Lokasi', $barang->lokasi_ditemukan],
                    ['<i class="fi fi-rr-calendar" style="margin-right:4px"></i> Tanggal', \Carbon\Carbon::parse($barang->tanggal_ditemukan)->translatedFormat('d F Y') . ', ' . substr($barang->jam_ditemukan,0,5) . ' WIB'],
                    ['<i class="fi fi-rr-wrench-simple" style="margin-right:4px"></i> Kondisi', $barang->kondisi],
                    ['<i class="fi fi-rr-user" style="margin-right:4px"></i> Ditemukan oleh', $barang->ditemukan_oleh],
                ] as [$label, $value])
                <div style="display:grid;grid-template-columns:160px 1fr;gap:0.5rem;font-size:0.9rem;padding-bottom:0.65rem;border-bottom:1px solid var(--border)">
                    <span style="color:var(--text-muted);font-weight:600">{!! $label !!}</span>
                    <span style="font-weight:500">{{ $value }}</span>
                </div>
                @endforeach
                @if($barang->deskripsi)
                <div style="display:grid;grid-template-columns:160px 1fr;gap:0.5rem;font-size:0.9rem">
                    <span style="color:var(--text-muted);font-weight:600"><i class="fi fi-rr-document" style="margin-right:4px"></i> Keterangan</span>
                    <span>{{ $barang->deskripsi }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- DAFTAR KLAIM MASUK --}}
        <div class="card">
            <div class="card-header">
                <h3><i class="fi fi-rr-clipboard-list" style="margin-right:6px"></i> Klaim Masuk ({{ $barang->klaims->count() }})</h3>
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
                                        <span class="badge badge-warning"><i class="fi fi-rr-clock-three" style="margin-right:3px"></i> Menunggu</span>
                                    @elseif($klaim->status === 'disetujui')
                                        <span class="badge badge-success"><i class="fi fi-sr-check-circle" style="margin-right:3px"></i> Disetujui</span>
                                    @else
                                        <span class="badge badge-danger"><i class="fi fi-sr-cross-circle" style="margin-right:3px"></i> Ditolak</span>
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


@endsection

