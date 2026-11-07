<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaPembelajaran extends Model
{
    protected $table = 'media_pembelajaran';

    protected $fillable = [
        'id_materi', 'judul_media', 'jenis_media', 'lokasi_file', 'tautan'
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }
}