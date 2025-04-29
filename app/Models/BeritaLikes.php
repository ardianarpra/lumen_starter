<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaLikes extends Model
{
    public $timestamps = false;
    protected $table = 'berita_likes';

    protected $fillable = [
        'berita_id',
        'user_id',
    ];

    public function berita()
    {
        return $this->belongsTo(
            Berita::class
        );
    }
}
