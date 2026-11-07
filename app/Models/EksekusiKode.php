<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EksekusiKode extends Model
{
    protected $table = 'eksekusi_kode';

    protected $fillable = [
        'id_pelajar', 'id_contoh_kode', 'id_bahasa', 'kode_program',
        'hasil_output', 'pesan_error', 'status_eksekusi'
    ];

    public function pelajar()
    {
        return $this->belongsTo(User::class, 'id_pelajar');
    }

    public function contohKode()
    {
        return $this->belongsTo(ContohKode::class, 'id_contoh_kode');
    }

    public function bahasa()
    {
        return $this->belongsTo(BahasaPemrograman::class, 'id_bahasa');
    }
}