@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fi fi-rr-box-open"></i></div>
        <div class="stat-info">
            <h3>{{ $totalBarang }}</h3>
            <p>Total Barang</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fi fi-rr-check-circle"></i></div>
        <div class="stat-info">
            <h3>{{ $totalTersimpan }}</h3>
            <p>Menunggu Pemilik</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fi fi-rr-clock-three"></i></div>
        <div class="stat-info">
            <h3>{{ $totalKlaimMenunggu }}</h3>
            <p>Klaim Perlu Diverifikasi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fi fi-rr-party-horn"></i></div>
        <div class="stat-info">
            <h3>{{ $totalDikembalikan }}</h3>
            <p>Berhasil Dikembalikan</p>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">

    {{-- KLAIM MENUNGGU --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fi fi-rr-clock-three" style="margin-right:6px"></i> Klaim Perlu Diverifikasi</h3>
            <a href="{{ route('admin.klaim.index', ['status'=>'menunggu']) }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        @if($klaimTerbaru->isEmpty())
            <div class="card-body">
                <div class="empty-state" style="padding:1.5rem">
                    <div class="empty-icon" style="font-size:2rem"><i class="fi fi-rr-check-circle" style="font-size:2rem"></i></div>
                    <p>Tidak ada klaim yang menunggu</p>
                </div>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Pengklaim</th>
                            <th>Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($klaimTerbaru as $klaim)
                        <tr>
                            <td>
                                <div style="font-weight:600">{{ $klaim->nama_pengklaim }}</div>
                                <div style="font-size:0.8rem;color:var(--text-muted)">{{ $klaim->kelas }}</div>
                            </td>
                            <td style="font-size:0.85rem">{{ $klaim->barang->nama_barang }}</td>
                            <td>
                                <a href="{{ route('admin.klaim.show', $klaim->id) }}" class="btn btn-sm btn-primary">Verifikasi</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- BARANG TERBARU --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fi fi-rr-box-open" style="margin-right:6px"></i> Barang Terbaru</h3>
            <a href="{{ route('admin.barang.create') }}" class="btn btn-sm btn-accent">+ Tambah</a>
        </div>
        @if($barangTerbaru->isEmpty())
            <div class="card-body">
                <div class="empty-state" style="padding:1.5rem">
                    <p>Belum ada barang</p>
                </div>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangTerbaru as $barang)
                        <tr>
                            <td>
                                <div style="font-weight:600">{{ $barang->nama_barang }}</div>
                                <div style="font-size:0.78rem;color:var(--text-muted)">{{ $barang->kode_unik }}</div>
                            </td>
                            <td>
                                @if($barang->status === 'tersimpan')
                                    <span class="badge badge-success">Tersimpan</span>
                                @elseif($barang->status === 'diklaim')
                                    <span class="badge badge-warning">Diklaim</span>
                                @else
                                    <span class="badge badge-secondary">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn btn-sm btn-secondary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@endsection
