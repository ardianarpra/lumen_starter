<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GawatDarurat extends Model
{
    protected $table = 'gawat_darurat';

    protected $fillable = [
        'jenis_gawat_darurat',
        'nama_pelapor',
        'telp_pelapor',
        'latitude',
        'longitude',
        'penilaian',
        'keterangan_penilaian',
    ];

    public function kategoriPenilaian()
    {
        return $this->belongsToMany(
            GawatDaruratKategoriPenilaian::class,
            'gd_kategori_penilaian_pivot',
            'gawat_darurat_id',
            'kategori_penilaian_id'
        );
    }
}
