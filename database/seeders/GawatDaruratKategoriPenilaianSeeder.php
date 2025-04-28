<?php

namespace Database\Seeders;

use App\Models\GawatDaruratKategoriPenilaian;
use Illuminate\Database\Seeder;

class GawatDaruratKategoriPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Tidak Dihubungi']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Layanan Buruk']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Penanganan Lama']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Tidak Menyelesaikan Masalah']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Tidak Sopan']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Cepat Dihubungi']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Layanan Baik']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Penanganan Cepat']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Sangat Terbantu']);
        GawatDaruratKategoriPenilaian::create(['nama_kategori' => 'Mantap']);
    }
}
