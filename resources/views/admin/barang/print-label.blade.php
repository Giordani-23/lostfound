<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label QR — {{ $barang->kode_unik }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap');

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

        /* ── LABEL CARD (di layar) ── */
        .label-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 360px;
            width: 100%;
        }
        .label-header {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #6B7280;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .label-qr {
            margin: 0.75rem auto;
            display: flex;
            justify-content: center;
        }
        .label-qr svg {
            width: 140px !important;
            height: 140px !important;
        }
        .label-kode {
            font-weight: 900;
            font-size: 1.1rem;
            color: #111827;
            margin-top: 0.5rem;
        }
        .label-nama {
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            margin-top: 4px;
        }
        .label-info {
            font-size: 0.75rem;
            color: #9CA3AF;
            margin-top: 2px;
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
            .label-card {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 2mm !important;
                max-width: none !important;
                width: 100% !important;
            }
            .label-header { font-size: 7pt !important; }
            .label-qr svg {
                width: 30mm !important;
                height: 30mm !important;
            }
            .label-kode { font-size: 10pt !important; }
            .label-nama { font-size: 8pt !important; }
            .label-info { font-size: 7pt !important; }
        }
    </style>
</head>
<body>

<div class="label-card">
    <div class="label-header">SMKN 1 SURABAYA — LOST & FOUND</div>
    <div class="label-qr">
        {!! $qrCode !!}
    </div>
    <div class="label-kode">{{ $barang->kode_unik }}</div>
    <div class="label-nama">{{ $barang->nama_barang }}</div>
    <div class="label-info">📍 {{ $barang->lokasi_ditemukan }}</div>
    <div class="label-info">📅 {{ \Carbon\Carbon::parse($barang->tanggal_ditemukan)->format('d/m/Y') }}</div>
</div>

<div class="toolbar">
    <button class="btn-print" onclick="window.print()">🖨️ Cetak Label</button>
    <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn-back">← Kembali</a>
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
