@extends('layouts.admin')

@section('title', 'Daftar Klaim')
@section('page-title', 'Kelola Klaim')

@section('content')

{{-- FILTER --}}
<div class="card card-body mb-3">
    <form method="GET">
        <div style="display:flex;gap:1rem;align-items:flex-end">
            <div class="form-group" style="margin:0;flex:1">
                <label class="form-label">Filter Status</label>
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">Semua Klaim</option>
                    <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}><i class="fi fi-rr-clock-three"></i> Menunggu Verifikasi</option>
                    <option value="disetujui" {{ request('status')=='disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <a href="{{ route('admin.klaim.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Pengklaim</th>
                    <th>Barang</th>
                    <th>Tanggal Klaim</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($klaims as $klaim)
                <tr>
                    <td>
                        <div style="font-weight:700">{{ $klaim->nama_pengklaim }}</div>
                        <div style="font-size:0.8rem;color:var(--text-muted)">{{ $klaim->kelas }} · {{ $klaim->no_hp }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600">{{ $klaim->barang->nama_barang }}</div>
                        <div style="font-size:0.78rem;color:var(--text-muted)">{{ $klaim->barang->kode_unik }}</div>
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
                        <a href="{{ route('admin.klaim.show', $klaim->id) }}" class="btn btn-sm btn-primary">
                            {{ $klaim->status === 'menunggu' ? 'Verifikasi' : 'Detail' }}
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fi fi-rr-mailbox" style="font-size:3rem"></i></div>
                                <h3>Tidak ada klaim</h3>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($klaims->hasPages())
        <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">
            <div class="pagination">{{ $klaims->appends(request()->query())->links() }}</div>
        </div>
    @endif
</div>

@endsection
