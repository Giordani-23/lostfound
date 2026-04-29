<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    protected $fillable = [
        'barang_id',
        'nama_pengklaim',
        'kelas',
        'no_hp',
        'ciri_khusus',
        'status',
        'catatan_admin',
    ];

    /**
     * Relasi: satu klaim milik satu barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
