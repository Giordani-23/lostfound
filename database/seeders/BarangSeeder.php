<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barangs = [
            [
                'kode_unik'          => 'LF-2026-0001',
                'nama_barang'        => 'Dompet Hitam',
                'kategori'           => 'Aksesoris',
                'lokasi_ditemukan'   => 'Kantin Lantai 1',
                'tanggal_ditemukan'  => '2026-04-20',
                'jam_ditemukan'      => '10:30:00',
                'deskripsi'          => 'Dompet kulit warna hitam, ada beberapa kartu di dalamnya',
                'kondisi'            => 'Baik',
                'foto_utama'         => null,
                'status'             => 'tersimpan',
                'ditemukan_oleh'     => 'Pak Budi',
            ],
            [
                'kode_unik'          => 'LF-2026-0002',
                'nama_barang'        => 'Earphone Putih',
                'kategori'           => 'Elektronik',
                'lokasi_ditemukan'   => 'Laboratorium Komputer',
                'tanggal_ditemukan'  => '2026-04-21',
                'jam_ditemukan'      => '13:00:00',
                'deskripsi'          => 'Earphone warna putih, kondisi kabel masih bagus',
                'kondisi'            => 'Baik',
                'foto_utama'         => null,
                'status'             => 'tersimpan',
                'ditemukan_oleh'     => 'Bu Sari',
            ],
            [
                'kode_unik'          => 'LF-2026-0003',
                'nama_barang'        => 'Buku Tulis',
                'kategori'           => 'Alat Tulis',
                'lokasi_ditemukan'   => 'Kelas XI RPL 2',
                'tanggal_ditemukan'  => '2026-04-22',
                'jam_ditemukan'      => '08:00:00',
                'deskripsi'          => 'Buku tulis sampul biru, ada nama di halaman pertama',
                'kondisi'            => 'Baik',
                'foto_utama'         => null,
                'status'             => 'dikembalikan',
                'ditemukan_oleh'     => 'Pak Agus',
            ],
            [
                'kode_unik'          => 'LF-2026-0004',
                'nama_barang'        => 'Jaket Hitam',
                'kategori'           => 'Pakaian',
                'lokasi_ditemukan'   => 'Mushola',
                'tanggal_ditemukan'  => '2026-04-23',
                'jam_ditemukan'      => '12:15:00',
                'deskripsi'          => 'Jaket hitam ukuran M, ada logo sekolah di dada kiri',
                'kondisi'            => 'Baik',
                'foto_utama'         => null,
                'status'             => 'tersimpan',
                'ditemukan_oleh'     => 'Bu Rini',
            ],
            [
                'kode_unik'          => 'LF-2026-0005',
                'nama_barang'        => 'Kalkulator Scientific',
                'kategori'           => 'Elektronik',
                'lokasi_ditemukan'   => 'Perpustakaan',
                'tanggal_ditemukan'  => '2026-04-24',
                'jam_ditemukan'      => '09:45:00',
                'deskripsi'          => 'Kalkulator scientific warna biru',
                'kondisi'            => 'Baik',
                'foto_utama'         => null,
                'status'             => 'diklaim',
                'ditemukan_oleh'     => 'Pak Joko',
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
