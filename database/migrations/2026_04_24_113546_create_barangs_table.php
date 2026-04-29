<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unik')->unique();
            $table->string('nama_barang');
            $table->enum('kategori', ['Elektronik', 'Alat Tulis', 'Pakaian', 'Aksesoris', 'Lainnya']);
            $table->string('lokasi_ditemukan');
            $table->date('tanggal_ditemukan');
            $table->time('jam_ditemukan');
            $table->text('deskripsi')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->string('foto_utama')->nullable();
            $table->enum('status', ['tersimpan', 'diklaim', 'dikembalikan'])->default('tersimpan');
            $table->string('ditemukan_oleh');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
