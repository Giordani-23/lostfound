<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Klaim;
use App\Models\Barang;
use Illuminate\Http\Request;

class KlaimController extends Controller
{
    // List semua klaim
    public function index(Request $request)
    {
        $query = Klaim::with('barang');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $klaims = $query->latest()->paginate(10);
        return view('admin.klaim.index', compact('klaims'));
    }

    // Detail klaim
    public function show($id)
    {
        $klaim = Klaim::with('barang')->findOrFail($id);
        return view('admin.klaim.show', compact('klaim'));
    }

    // Cetak struk serah terima (halaman khusus print)
    public function printStruk($id)
    {
        $klaim = Klaim::with('barang')->findOrFail($id);
        return view('admin.klaim.print-struk', compact('klaim'));
    }

    // Setujui atau tolak klaim
    public function update(Request $request, $id)
    {
        $klaim  = Klaim::with('barang')->findOrFail($id);
        $aksi   = $request->aksi; // 'setujui' atau 'tolak'

        if ($aksi === 'setujui') {
            $klaim->update([
                'status'         => 'disetujui',
                'catatan_admin'  => $request->catatan_admin,
            ]);

            // Update status barang jadi dikembalikan
            $klaim->barang->update(['status' => 'dikembalikan']);

            return redirect()->route('admin.klaim.show', $klaim->id)
                             ->with('success', 'Klaim disetujui. Barang siap diserahkan ke pemilik. Silakan cetak struk serah terima.');
        }

        if ($aksi === 'tolak') {
            $request->validate([
                'catatan_admin' => 'required|string',
            ], [
                'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
            ]);

            $klaim->update([
                'status'        => 'ditolak',
                'catatan_admin' => $request->catatan_admin,
            ]);

            // Kembalikan status barang ke tersimpan
            $klaim->barang->update(['status' => 'tersimpan']);

            return redirect()->route('admin.klaim.show', $klaim->id)
                             ->with('success', 'Klaim ditolak. Barang dikembalikan ke status tersimpan.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }
}
