<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Klaim;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang       = Barang::count();
        $totalTersimpan    = Barang::where('status', 'tersimpan')->count();
        $totalDiklaim      = Barang::where('status', 'diklaim')->count();
        $totalDikembalikan = Barang::where('status', 'dikembalikan')->count();
        $totalKlaimMenunggu = Klaim::where('status', 'menunggu')->count();

        $klaimTerbaru = Klaim::with('barang')
                             ->where('status', 'menunggu')
                             ->latest()
                             ->take(5)
                             ->get();

        $barangTerbaru = Barang::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBarang',
            'totalTersimpan',
            'totalDiklaim',
            'totalDikembalikan',
            'totalKlaimMenunggu',
            'klaimTerbaru',
            'barangTerbaru'
        ));
    }
}
