<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $table = 'modul';

    protected $fillable = [
        'id_bahasa', 'id_instruktur', 'nama_modul', 'deskripsi', 'urutan', 'status'
    ];

    public function bahasa()
    {
        return $this->belongsTo(BahasaPemrograman::class, 'id_bahasa');
    }

    public function instruktur()
    {
        return $this->belongsTo(User::class, 'id_instruktur');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_modul');
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'id_modul');
    }

    public function progresBelajar()
    {
        return $this->hasMany(ProgresBelajar::class, 'id_modul');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_modul');
    }
}