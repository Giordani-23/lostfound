<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_unik',
        'nama_barang',
        'kategori',
        'lokasi_ditemukan',
        'tanggal_ditemukan',
        'jam_ditemukan',
        'deskripsi',
        'kondisi',
        'foto_utama',
        'status',
        'ditemukan_oleh',
    ];

    /**
     * Auto-generate kode unik: LF-2026-0001
     */
    public static function generateKode(): string
    {
        $tahun  = date('Y');
        $prefix = 'LF-' . $tahun . '-';

        // Cari nomor urut terakhir yang sudah ada di tahun ini
        $last = self::where('kode_unik', 'like', $prefix . '%')
                    ->orderByRaw("CAST(SUBSTRING(kode_unik, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
                    ->value('kode_unik');

        $nextNumber = 1;
        if ($last) {
            $lastNumber = (int) str_replace($prefix, '', $last);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi: satu barang punya banyak klaim
     */
    public function klaims()
    {
        return $this->hasMany(Klaim::class);
    }

    /**
     * Hanya klaim yang statusnya menunggu
     */
    public function klaimMenunggu()
    {
        return $this->hasMany(Klaim::class)->where('status', 'menunggu');
    }
}
