<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContohKode extends Model
{
    protected $table = 'contoh_kode';

    protected $fillable = [
        'id_bahasa', 'id_materi', 'id_instruktur', 'judul', 'deskripsi', 'kode_program', 'hasil_diharapkan'
    ];

    public function bahasa()
    {
        return $this->belongsTo(BahasaPemrograman::class, 'id_bahasa');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }

    public function instruktur()
    {
        return $this->belongsTo(User::class, 'id_instruktur');
    }

    public function eksekusi()
    {
        return $this->hasMany(EksekusiKode::class, 'id_contoh_kode');
    }
}