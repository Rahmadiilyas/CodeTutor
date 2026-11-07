<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';

    protected $fillable = [
        'id_modul', 'judul_materi', 'deskripsi', 'isi_materi', 'urutan', 'status'
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul');
    }

    public function media()
    {
        return $this->hasMany(MediaPembelajaran::class, 'id_materi');
    }

    public function contohKode()
    {
        return $this->hasMany(ContohKode::class, 'id_materi');
    }
}