@extends('layouts.admin')

@section('title', 'Tambah Barang')
@section('page-title', 'Tambah Barang Temuan')

@section('content')

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

    {{-- KOLOM KIRI: WEBCAM --}}
    <div class="card card-body">
        <h3 style="font-weight:700;margin-bottom:1rem">📷 Foto Barang</h3>

        {{-- WEBCAM PREVIEW --}}
        <div class="webcam-container mb-2" id="webcam-box">
            <video id="webcam-video" autoplay playsinline></video>
            <div class="webcam-overlay">
                <button type="button" class="btn btn-accent" id="btn-foto" onclick="ambilFoto()">📸 Ambil Foto</button>
            </div>
        </div>

        {{-- CANVAS TERSEMBUNYI --}}
        <canvas id="canvas" width="640" height="480" style="display:none"></canvas>

        {{-- PREVIEW FOTO --}}
        <div id="preview-box" style="display:none;margin-bottom:1rem">
            <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:0.5rem">Preview foto:</p>
            <img id="preview-img" src="" alt="Preview"
                 style="width:100%;border-radius:var(--radius-sm);border:2px solid var(--accent)">
            <button type="button" class="btn btn-secondary btn-sm mt-1 w-100" onclick="ulangi()">🔄 Ulangi Foto</button>
        </div>

        <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:0.75rem;text-align:center">— atau —</p>

        {{-- UPLOAD FILE --}}
        <div class="form-group">
            <label class="form-label">Upload dari File</label>
            <input type="file" name="foto_file_preview" id="foto-file-input"
                   class="form-control" accept="image/*" onchange="previewUpload(this)">
        </div>

        {{-- STATUS WEBCAM --}}
        <div id="webcam-status" class="alert alert-info" style="font-size:0.82rem;display:none">
            ⚠️ Webcam tidak tersedia. Gunakan upload file.
        </div>
    </div>

    {{-- KOLOM KANAN: FORM --}}
    <div class="card card-body">
        <h3 style="font-weight:700;margin-bottom:1rem">📝 Data Barang</h3>

        @if($errors->any())
            <div class="alert alert-error">❌ {{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.barang.store') }}" method="POST" id="form-barang">
            @csrf
            {{-- Input tersembunyi untuk foto base64 dari webcam --}}
            <input type="hidden" name="foto_base64" id="foto-base64">
            {{-- Input tersembunyi untuk foto file --}}
            <input type="hidden" name="foto_file_b64" id="foto-file-b64">

            <div class="form-group">
                <label class="form-label">Nama Barang <span class="required">*</span></label>
                <input type="text" name="nama_barang" class="form-control" placeholder="cth: Dompet Hitam" value="{{ old('nama_barang') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kategori <span class="required">*</span></label>
                    <select name="kategori" class="form-control" required>
                        <option value="">Pilih kategori...</option>
                        @foreach(['Elektronik','Alat Tulis','Pakaian','Aksesoris','Lainnya'] as $k)
                            <option value="{{ $k }}" {{ old('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kondisi <span class="required">*</span></label>
                    <select name="kondisi" class="form-control" required>
                        <option value="">Pilih kondisi...</option>
                        @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                            <option value="{{ $k }}" {{ old('kondisi') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi Ditemukan <span class="required">*</span></label>
                <input type="text" name="lokasi_ditemukan" class="form-control" placeholder="cth: Kantin Lantai 1, Kelas XI RPL 2" value="{{ old('lokasi_ditemukan') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Ditemukan <span class="required">*</span></label>
                    <input type="date" name="tanggal_ditemukan" class="form-control" value="{{ old('tanggal_ditemukan', date('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Ditemukan <span class="required">*</span></label>
                    <input type="time" name="jam_ditemukan" class="form-control" value="{{ old('jam_ditemukan', date('H:i')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ditemukan Oleh <span class="required">*</span></label>
                <input type="text" name="ditemukan_oleh" class="form-control" placeholder="Nama petugas / penemu" value="{{ old('ditemukan_oleh', Auth::user()->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan Tambahan</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Ciri-ciri tambahan barang...">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit" class="btn btn-accent btn-block btn-lg">
                💾 Simpan & Cetak Label QR
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── WEBCAM ────────────────────────────────────────────────
const video    = document.getElementById('webcam-video');
const canvas   = document.getElementById('canvas');
const b64Input = document.getElementById('foto-base64');
let fotoMode   = null; // 'webcam' atau 'file'

navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
    })
    .catch(() => {
        document.getElementById('webcam-status').style.display = 'flex';
        document.getElementById('webcam-box').style.display = 'none';
    });

function ambilFoto() {
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, 640, 480);
    const dataUrl = canvas.toDataURL('image/jpeg', 0.85);

    b64Input.value = dataUrl;
    fotoMode = 'webcam';

    document.getElementById('preview-img').src = dataUrl;
    document.getElementById('preview-box').style.display = 'block';
    document.getElementById('webcam-box').style.display = 'none';
}

function ulangi() {
    b64Input.value = '';
    fotoMode = null;
    document.getElementById('preview-box').style.display = 'none';
    document.getElementById('webcam-box').style.display = 'block';
}

// ── UPLOAD FILE ───────────────────────────────────────────
function previewUpload(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        b64Input.value = e.target.result;
        fotoMode = 'file';
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-box').style.display = 'block';
        document.getElementById('webcam-box').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
