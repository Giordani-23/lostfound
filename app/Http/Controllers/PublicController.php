<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Klaim;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Halaman beranda
    public function index()
    {
        $totalBarang     = Barang::count();
        $totalDikembalikan = Barang::where('status', 'dikembalikan')->count();
        $totalTersimpan  = Barang::where('status', 'tersimpan')->count();
        $barangTerbaru   = Barang::where('status', 'tersimpan')
                                 ->latest()
                                 ->take(6)
                                 ->get();

        return view('public.home', compact(
            'totalBarang', 'totalDikembalikan', 'totalTersimpan', 'barangTerbaru'
        ));
    }

    // Halaman galeri semua barang
    public function galeri(Request $request)
    {
        $query = Barang::where('status', '!=', 'dikembalikan');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi_ditemukan', 'like', '%' . $request->lokasi . '%');
        }
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->latest()->paginate(9);

        return view('public.galeri', compact('barangs'));
    }

    // Halaman detail barang
    public function detail($id)
    {
        $barang = Barang::findOrFail($id);
        return view('public.detail', compact('barang'));
    }

    // Proses pengajuan klaim
    public function klaim(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->status !== 'tersimpan') {
            return back()->with('error', 'Barang ini sudah tidak bisa diklaim.');
        }

        $request->validate([
            'nama_pengklaim' => 'required|string|max:100',
            'kelas'          => 'required|string|max:20',
            'no_hp'          => 'required|string|max:15',
            'ciri_khusus'    => 'required|string|min:20',
        ], [
            'nama_pengklaim.required' => 'Nama wajib diisi.',
            'kelas.required'          => 'Kelas wajib diisi.',
            'no_hp.required'          => 'Nomor HP wajib diisi.',
            'ciri_khusus.required'    => 'Ciri khusus wajib diisi.',
            'ciri_khusus.min'         => 'Ciri khusus minimal 20 karakter. Jelaskan lebih detail!',
        ]);

        Klaim::create([
            'barang_id'      => $barang->id,
            'nama_pengklaim' => $request->nama_pengklaim,
            'kelas'          => $request->kelas,
            'no_hp'          => $request->no_hp,
            'ciri_khusus'    => $request->ciri_khusus,
            'status'         => 'menunggu',
        ]);

        // Update status barang jadi "diklaim"
        $barang->update(['status' => 'diklaim']);

        return back()->with('success', 'Klaim berhasil diajukan! Tunggu konfirmasi dari petugas piket via WhatsApp ke nomor yang kamu daftarkan.');
    }
}
