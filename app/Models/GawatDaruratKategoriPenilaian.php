<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GawatDaruratKategoriPenilaian extends Model
{
    protected $table = 'gd_kategori_penilaian';

    protected $fillable = [
        'nama_kategori'
    ];

    public function gawatDarurat()
    {
        return $this->belongsToMany(
            GawatDarurat::class,
            'gd_kategori_penilaian_pivot',
            'kategori_penilaian_id',
            'gawat_darurat_id'
        );
    }
}
