<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'thumbnail',
        'berita',
        'total_likes',
    ];

    public function beritaLikes()
    {
        return $this->hasMany(
            BeritaLikes::class
        );
    }
}
