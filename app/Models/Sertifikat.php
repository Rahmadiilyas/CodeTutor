<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'id_pelajar', 'id_instruktur', 'id_modul', 'judul_sertifikat',
        'nomor_sertifikat', 'tanggal_terbit', 'lokasi_file', 'status'
    ];

    public function pelajar()
    {
        return $this->belongsTo(User::class, 'id_pelajar');
    }

    public function instruktur()
    {
        return $this->belongsTo(User::class, 'id_instruktur');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul');
    }
}