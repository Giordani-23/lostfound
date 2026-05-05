<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Serah Terima — {{ $klaim->barang->kode_unik }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <style>

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        /* ── STRUK CARD (di layar) ── */
        .struk-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            max-width: 380px;
            width: 100%;
            font-size: 0.9rem;
        }
        .struk-header {
            text-align: center;
            border-bottom: 2px dashed #D1D5DB;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        .struk-header .school-name {
            font-weight: 800;
            font-size: 1rem;
            color: #111827;
        }
        .struk-header .school-address {
            font-size: 0.75rem;
            color: #6B7280;
            margin-top: 2px;
        }
        .struk-header .struk-title {
            font-weight: 800;
            font-size: 0.85rem;
            color: #111827;
            margin-top: 0.75rem;
            padding: 6px 0;
            border-top: 1px solid #111827;
            border-bottom: 1px solid #111827;
        }
        .struk-header .struk-sub {
            font-size: 0.75rem;
            color: #6B7280;
            margin-top: 2px;
        }
        .struk-section-title {
            font-weight: 800;
            font-size: 0.8rem;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .struk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }
        .struk-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .struk-table .label {
            width: 38%;
            font-weight: 600;
            color: #374151;
        }
        .struk-table .value {
            color: #111827;
        }
        .struk-divider {
            border: none;
            border-top: 2px dashed #D1D5DB;
            margin: 1rem 0;
        }
        .struk-date {
            font-size: 0.78rem;
            color: #6B7280;
        }
        .struk-signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
            font-size: 0.78rem;
            text-align: center;
            color: #374151;
        }
        .struk-signatures .sig-label {
            font-weight: 500;
        }
        .struk-signatures .sig-space {
            height: 50px;
        }
        .struk-signatures .sig-name {
            border-top: 1px solid #111827;
            padding-top: 4px;
            font-weight: 700;
        }

        /* ── TOOLBAR (hanya tampil di layar) ── */
        .toolbar {
            margin-top: 1.5rem;
            display: flex;
            gap: 0.75rem;
        }
        .toolbar a, .toolbar button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.7rem 1.5rem;
            border-radius: 9999px;
            font-family: inherit;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-print {
            background: #FF7A00;
            color: #fff;
        }
        .btn-print:hover {
            background: #E66D00;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255,122,0,0.3);
        }
        .btn-back {
            background: #F3F4F6;
            color: #374151;
        }
        .btn-back:hover {
            background: #E5E7EB;
        }
        .tip {
            margin-top: 1rem;
            font-size: 0.78rem;
            color: #9CA3AF;
            font-weight: 500;
        }

        /* ── PRINT STYLES ── */
        @media print {
            @page {
                size: 58mm auto;
                margin: 2mm;
            }
            html, body {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
            }
            .toolbar, .tip { display: none !important; }
            .struk-card {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                max-width: none !important;
                width: 100% !important;
                font-size: 8pt !important;
            }
            .struk-header .school-name { font-size: 10pt !important; }
            .struk-header .school-address { font-size: 7pt !important; }
            .struk-header .struk-title { font-size: 8pt !important; }
            .struk-header .struk-sub { font-size: 7pt !important; }
            .struk-section-title { font-size: 8pt !important; }
            .struk-table { font-size: 8pt !important; }
            .struk-table td { padding: 1mm 0 !important; }
            .struk-date { font-size: 7pt !important; }
            .struk-signatures { font-size: 7pt !important; gap: 4mm !important; margin-top: 4mm !important; }
            .struk-signatures .sig-space { height: 14mm !important; }
        }
    </style>
</head>
<body>

<div class="struk-card">
    {{-- HEADER --}}
    <div class="struk-header">
        <div class="school-name">SMKN 1 SURABAYA</div>
        <div class="school-address">Jl. SMEA No.4, Wonokromo, Surabaya</div>
        <div class="struk-title">BUKTI SERAH TERIMA BARANG</div>
        <div class="struk-sub">LOST & FOUND</div>
    </div>

    {{-- DATA BARANG --}}
    <table class="struk-table">
        <tr><td class="label">Kode Barang</td><td class="value">: {{ $klaim->barang->kode_unik }}</td></tr>
        <tr><td class="label">Nama Barang</td><td class="value">: {{ $klaim->barang->nama_barang }}</td></tr>
        <tr><td class="label">Kondisi</td><td class="value">: {{ $klaim->barang->kondisi }}</td></tr>
        <tr><td class="label">Ditemukan di</td><td class="value">: {{ $klaim->barang->lokasi_ditemukan }}</td></tr>
    </table>

    <hr class="struk-divider">

    {{-- DATA PENERIMA --}}
    <div class="struk-section-title">DATA PENERIMA:</div>
    <table class="struk-table">
        <tr><td class="label">Nama</td><td class="value">: {{ $klaim->nama_pengklaim }}</td></tr>
        <tr><td class="label">Kelas</td><td class="value">: {{ $klaim->kelas }}</td></tr>
        <tr><td class="label">No. HP</td><td class="value">: {{ $klaim->no_hp }}</td></tr>
    </table>

    <hr class="struk-divider">

    {{-- TANGGAL --}}
    <div class="struk-date">
        Tanggal Pengambilan: {{ now()->format('d/m/Y H:i') }} WIB
    </div>

    {{-- TANDA TANGAN --}}
    <div class="struk-signatures">
        <div>
            <div class="sig-label">Diserahkan oleh,</div>
            <div class="sig-space"></div>
            <div class="sig-name">( Petugas Piket )</div>
        </div>
        <div>
            <div class="sig-label">Diterima oleh,</div>
            <div class="sig-space"></div>
            <div class="sig-name">( {{ $klaim->nama_pengklaim }} )</div>
        </div>
    </div>
</div>

<div class="toolbar">
    <button class="btn-print" onclick="window.print()"><i class="fi fi-rr-print" style="margin-right:4px"></i> Cetak Struk</button>
    <a href="{{ route('admin.klaim.show', $klaim->id) }}" class="btn-back">← Kembali</a>
</div>
<p class="tip">Pastikan thermal printer (58mm) sudah jadi default printer</p>

<script>
    // Auto-print saat halaman selesai load
    window.addEventListener('load', function() {
        setTimeout(() => window.print(), 400);
    });
</script>

</body>
</html>
