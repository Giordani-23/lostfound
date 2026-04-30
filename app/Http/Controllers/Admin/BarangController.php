<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // List semua barang
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->latest()->paginate(10);
        return view('admin.barang.index', compact('barangs'));
    }

    // Form tambah barang (ada webcam)
    public function create()
    {
        return view('admin.barang.create');
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'       => 'required|string|max:100',
            'kategori'          => 'required',
            'lokasi_ditemukan'  => 'required|string|max:100',
            'tanggal_ditemukan' => 'required|date',
            'jam_ditemukan'     => 'required',
            'kondisi'           => 'required',
            'ditemukan_oleh'    => 'required|string|max:100',
        ]);

        // Validasi: foto WAJIB (dari webcam atau upload)
        if (!$request->filled('foto_base64') && !$request->hasFile('foto_file')) {
            return back()->withInput()->withErrors(['foto' => 'Foto barang wajib diambil! Gunakan webcam atau upload file.']);
        }

        $fotoPath = null;
        $saveTo   = public_path('uploads/barang');

        // Pastikan folder ada
        if (!file_exists($saveTo)) {
            mkdir($saveTo, 0755, true);
        }

        // Proses foto dari webcam (base64)
        if ($request->filled('foto_base64')) {
            $base64 = $request->foto_base64;
            $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
            $nama   = 'barang_' . time() . '.jpg';
            file_put_contents($saveTo . '/' . $nama, base64_decode($base64));
            $fotoPath = $nama;
        }
        // Proses foto dari upload file
        elseif ($request->hasFile('foto_file')) {
            $file = $request->file('foto_file');
            $nama = 'barang_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($saveTo, $nama);
            $fotoPath = $nama;
        }

        $barang = Barang::create([
            'kode_unik'          => Barang::generateKode(),
            'nama_barang'        => $request->nama_barang,
            'kategori'           => $request->kategori,
            'lokasi_ditemukan'   => $request->lokasi_ditemukan,
            'tanggal_ditemukan'  => $request->tanggal_ditemukan,
            'jam_ditemukan'      => $request->jam_ditemukan,
            'deskripsi'          => $request->deskripsi,
            'kondisi'            => $request->kondisi,
            'foto_utama'         => $fotoPath,
            'status'             => 'tersimpan',
            'ditemukan_oleh'     => $request->ditemukan_oleh,
        ]);

        return redirect()->route('admin.barang.show', $barang->id)
                         ->with('success', 'Barang berhasil disimpan! Silakan cetak label QR di bawah.');
    }

    // Detail barang (+ QR code)
    public function show($id)
    {
        $barang  = Barang::with('klaims')->findOrFail($id);
        $qrCode  = QrCode::format('svg')->size(130)->generate(route('barang.show', $barang->id));
        return view('admin.barang.show', compact('barang', 'qrCode'));
    }

    // Cetak label QR (halaman khusus print)
    public function printLabel($id)
    {
        $barang = Barang::findOrFail($id);
        $qrCode = QrCode::format('svg')->size(140)->generate(route('barang.show', $barang->id));
        return view('admin.barang.print-label', compact('barang', 'qrCode'));
    }

    // Form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang'       => 'required|string|max:100',
            'kategori'          => 'required',
            'lokasi_ditemukan'  => 'required|string|max:100',
            'tanggal_ditemukan' => 'required|date',
            'jam_ditemukan'     => 'required',
            'kondisi'           => 'required',
            'status'            => 'required',
            'ditemukan_oleh'    => 'required|string|max:100',
        ]);

        $barang->update($request->only([
            'nama_barang', 'kategori', 'lokasi_ditemukan',
            'tanggal_ditemukan', 'jam_ditemukan', 'deskripsi',
            'kondisi', 'status', 'ditemukan_oleh',
        ]));

        return redirect()->route('admin.barang.show', $barang->id)
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->foto_utama) {
            @unlink(public_path('uploads/barang/' . $barang->foto_utama));
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')
                         ->with('success', 'Barang berhasil dihapus.');
    }
}
