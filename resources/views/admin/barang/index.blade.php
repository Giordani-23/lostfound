@extends('layouts.admin')

@section('title', 'Daftar Barang')
@section('page-title', 'Daftar Barang Temuan')

@section('topbar-actions')
    <a href="{{ route('admin.barang.create') }}" class="btn btn-accent"><i class="fi fi-rr-add" style="margin-right:4px"></i> Tambah Barang</a>
@endsection

@section('content')

{{-- FILTER --}}
<div class="card card-body mb-3">
    <form method="GET" action="{{ route('admin.barang.index') }}">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:1rem;align-items:end">
            <div class="form-group" style="margin:0">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control" placeholder="Nama barang..." value="{{ request('search') }}">
            </div>
            <div class="form-group" style="margin:0">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="tersimpan" {{ request('status') == 'tersimpan' ? 'selected' : '' }}>Tersimpan</option>
                    <option value="diklaim" {{ request('status') == 'diklaim' ? 'selected' : '' }}>Diklaim</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
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
            <div style="display:flex;gap:0.5rem">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

{{-- TABEL --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Kode / Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                <tr>
                    <td>
                        <div style="width:50px;height:50px;border-radius:8px;overflow:hidden;background:var(--bg)">
                            @if($barang->foto_utama)
                                <img src="{{ asset('uploads/barang/' . $barang->foto_utama) }}"
                                     style="width:100%;height:100%;object-fit:cover">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:1.5rem"><i class="fi fi-rr-camera" style="color:var(--text-muted)"></i></div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:700">{{ $barang->nama_barang }}</div>
                        <div style="font-size:0.78rem;color:var(--text-muted)">{{ $barang->kode_unik }}</div>
                    </td>
                    <td><span class="badge badge-info">{{ $barang->kategori }}</span></td>
                    <td style="font-size:0.85rem">{{ $barang->lokasi_ditemukan }}</td>
                    <td style="font-size:0.85rem">{{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->format('d/m/Y') }}</td>
                    <td>
                        @if($barang->status === 'tersimpan')
                            <span class="badge badge-success"><i class="fi fi-sr-check-circle" style="margin-right:3px"></i> Tersimpan</span>
                        @elseif($barang->status === 'diklaim')
                            <span class="badge badge-warning"><i class="fi fi-rr-clock-three" style="margin-right:3px"></i> Diklaim</span>
                        @else
                            <span class="badge badge-secondary"><i class="fi fi-rr-check-double" style="margin-right:3px"></i> Dikembalikan</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:0.35rem">
                            <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fi fi-rr-mailbox" style="font-size:3rem"></i></div>
                                <h3>Belum ada barang</h3>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($barangs->hasPages())
        <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">
            <div class="pagination">{{ $barangs->appends(request()->query())->links() }}</div>
        </div>
    @endif
</div>

@endsection
