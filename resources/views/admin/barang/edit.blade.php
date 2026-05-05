@extends('layouts.admin')

@section('title', 'Edit Barang')
@section('page-title', 'Edit Barang')

@section('topbar-actions')
    <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn btn-secondary btn-sm">← Kembali</a>
@endsection

@section('content')

<div style="max-width:700px">
    <div class="card card-body">
        @if($errors->any())
            <div class="alert alert-error"><i class="fi fi-sr-cross-circle" style="margin-right:6px"></i> {{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Barang <span class="required">*</span></label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kategori <span class="required">*</span></label>
                    <select name="kategori" class="form-control" required>
                        @foreach(['Elektronik','Alat Tulis','Pakaian','Aksesoris','Lainnya'] as $k)
                            <option value="{{ $k }}" {{ old('kategori', $barang->kategori) == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kondisi <span class="required">*</span></label>
                    <select name="kondisi" class="form-control" required>
                        @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                            <option value="{{ $k }}" {{ old('kondisi', $barang->kondisi) == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi Ditemukan <span class="required">*</span></label>
                <input type="text" name="lokasi_ditemukan" class="form-control" value="{{ old('lokasi_ditemukan', $barang->lokasi_ditemukan) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Ditemukan <span class="required">*</span></label>
                    <input type="date" name="tanggal_ditemukan" class="form-control" value="{{ old('tanggal_ditemukan', $barang->tanggal_ditemukan) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Ditemukan <span class="required">*</span></label>
                    <input type="time" name="jam_ditemukan" class="form-control" value="{{ old('jam_ditemukan', substr($barang->jam_ditemukan,0,5)) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Status <span class="required">*</span></label>
                    <select name="status" class="form-control" required>
                        @foreach(['tersimpan','diklaim','dikembalikan'] as $s)
                            <option value="{{ $s }}" {{ old('status', $barang->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Ditemukan Oleh <span class="required">*</span></label>
                    <input type="text" name="ditemukan_oleh" class="form-control" value="{{ old('ditemukan_oleh', $barang->ditemukan_oleh) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan Tambahan</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
            </div>

            <div style="display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary btn-lg"><i class="fi fi-rr-disk" style="margin-right:4px"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn btn-secondary btn-lg">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
